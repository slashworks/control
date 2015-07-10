<?php
    namespace Slashworks\BackendBundle\DataFixtures\ORM;

    use Doctrine\Common\DataFixtures\FixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use Simple\ProfileBundle\Entity\User;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    class LoadUserData implements FixtureInterface, ContainerAwareInterface
    {

        /**
         * @var ContainerInterface
         */
        private $container;


        /**
         * {@inheritDoc}
         */
        public function setContainer(ContainerInterface $container = null)
        {

            var_dump('getting container here');
            $this->container = $container;
        }


        /**
         * {@inheritDoc}
         */
        public function load(ObjectManager $manager)
        {

            $user = new User();
            $user->setUsername("someuser");
            $user->setSalt(md5(uniqid()));
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword('blue', $user->getSalt()));
            $user->setEmail("someuser@mail.ca");

            $manager->persist($user);

            $manager->flush();
        }
    }