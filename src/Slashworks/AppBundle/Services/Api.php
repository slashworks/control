<?php
    /**
     *
     *          _           _                       _
     *         | |         | |                     | |
     *      ___| | __ _ ___| |____      _____  _ __| | _____
     *     / __| |/ _` / __| '_ \ \ /\ / / _ \| '__| |/ / __|
     *     \__ \ | (_| \__ \ | | \ V  V / (_) | |  |   <\__ \
     *     |___/_|\__,_|___/_| |_|\_/\_/ \___/|_|  |_|\_\___/
     *                                        web development
     *
     *     http://www.slash-works.de </> hallo@slash-works.de
     *
     *
     * @author      rwollenburg
     * @copyright   rwollenburg@slashworks
     * @since       23.01.15 08:13
     * @package     Slashworks\AppBundle
     *
     */

    namespace Slashworks\AppBundle\Services;

    use Slashworks\AppBundle\Model\ApiLog;
    use Symfony\Component\Debug\Exception\ContextErrorException;


    /**
     * Class Api
     *
     * @package Slashworks\classes\api
     */
    class Api
    {


        /**
         * @param $code
         * @param $message
         * @param $file
         * @param $line
         * @param $context
         *
         * @throws \Exception
         */
        public static function errorHandler($code, $message, $file, $line, $context)
        {

            throw new \Exception($message);
        }


        /**
         * @param      $method
         * @param      $params
         * @param      $url
         * @param      $publickey
         * @param null $oRemoteApp
         *
         * @return array|mixed
         * @throws \Exception
         */
        public static function call($method, $params, $url, $publickey, $oRemoteApp = null)
        {

            $response = "";
            try {
                $sOldErrorhandler = set_error_handler('Slashworks\AppBundle\Services\Api::errorHandler');

                if (!is_scalar($method)) {
                    throw new \Exception('Method name has no scalar value');
                }

                // check
                if (is_array($params)) {
                    // no keys
                    $params = array_values($params);
                } else {
                    throw new \Exception('Params must be given as array');
                }

                // prepares the request
                $request = array(
                    'method' => $method,
                    'params' => $params,
                    'id'     => rand(1, 999)
                );
                $request = json_encode($request);


                $rsa = new \Crypt_RSA();
                $rsa->loadKey($publickey);

                $conairKey = file_get_contents(__DIR__ . "/../Resources/private/api/keys/server/public.key");
                $aRequest  = array(
                    'pkey' => $conairKey,
                    'data' => base64_encode($rsa->encrypt($request))
                );

                $sRequest = json_encode($aRequest);

                $headers = array(
                    'Content-Type: application/json'
                );

                if ($oRemoteApp->getApiAuthType() == "http-basic") {
                    $sUsername = $oRemoteApp->getApiAuthHttpUser();
                    $sPassword = $oRemoteApp->getApiAuthHttpPassword();
                    if (!empty($sUsername) && !empty($sPassword)) {
                        $headers[] = "Authorization: Basic " . base64_encode($oRemoteApp->getApiAuthHttpUser() . ":" . $oRemoteApp->getApiAuthHttpPassword());
                    }
                }
                $oRequest = curl_init($url);
                curl_setopt($oRequest, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($oRequest, CURLOPT_TIMEOUT, 3);
                curl_setopt($oRequest, CURLOPT_POST, 1);
                curl_setopt($oRequest, CURLOPT_POSTFIELDS, $sRequest);
                curl_setopt($oRequest, CURLOPT_RETURNTRANSFER, true);
                $response    = curl_exec($oRequest);
                $iHttpStatus = curl_getinfo($oRequest, CURLINFO_HTTP_CODE);
                $error = curl_error($oRequest);
                curl_close($oRequest);

                $rawResponse = $response;

                if ($response == "") {
                    throw new \Exception("No content received");
                }
                if ($iHttpStatus === 200) {
                    $response = json_decode($response, true);

                    if (!isset($response['data'])) {
                        throw new \Exception("Invalid response format: ".htmlentities($rawResponse));
                    }

                    $privateKey = file_get_contents(__DIR__ . "/../Resources/private/api/keys/server/private.key");
                    $rsa->loadKey($privateKey);
                    $data             = base64_decode($response['data']);
                    $decoded          = $rsa->decrypt($data);
                    $response['data'] = json_decode($decoded, true);
                    if (!is_array($response['data'])) {
                        throw new \Exception("Invalid response format: ".htmlentities($rawResponse));
                    }

                    $response['data']['statuscode'] = $iHttpStatus;
                    if($iHttpStatus !== 200){
                        $response['error'] = true;
                    }


                    ApiLog::create($iHttpStatus, $oRemoteApp->getId(), $decoded);


                    restore_error_handler();

                    return $response['data'];
                } else {

                    ApiLog::create($iHttpStatus, $oRemoteApp->getId(), $response);

                    restore_error_handler();

                    return array(
                        "statuscode" => $iHttpStatus,
                        "result"     => json_encode(array(
                                                        "status"     => false,
                                                        "error"     => true,
                                                        "statuscode" => $iHttpStatus,
                                                        "message"    => $response
                                                    )
                        )
                    );
                }


            } catch (ContextErrorException $e) {

                restore_error_handler();
                ApiLog::create(-1, $oRemoteApp->getId(), $e->getMessage());


                return array(
                    "statuscode" => $iHttpStatus,
                    "result"     => json_encode(array(
                                                    "status"     => false,
                                                    "error"     => true,
                                                    "statuscode" => -1,
                                                    "message"    => $e->getMessage()
                                                )
                    )
                );
            } catch (\Exception $e) {


                restore_error_handler();
                ApiLog::create(-1, $oRemoteApp->getId(), $e->getMessage());

                return array(
                    "statuscode" => 500,
                    "result"     => json_encode(array(
                                                    "status"     => false,
                                                    "error"     => true,
                                                    "statuscode" => -1,
                                                    "message"    => $e->getMessage()
                                                )
                    )
                );
            }
        }
    }