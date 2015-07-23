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
  * @since       10.07.2015 10:27
  * @package     Slashworks\AppBundle
  *
  */

SYSTEM.runSingleApiCall = function (id, url, obj) {
    if (this.running == false) {
        this.running = true;
        var spinIcon = 'fa-refresh fa-spin fa-working';
        var callIcon = 'fa-refresh';
        var _self = this;
        var $callIcon = $('#api_call_' + id);
        $callIcon.removeClass(callIcon);
        $callIcon.addClass(spinIcon);
        $("#maintenanceMode_" + id).fadeOut("fast");
        $("#status_" + id).fadeOut("fast");
        $("#lastRun_" + id).fadeOut("fast");
        var oCurrRow = $("#row_" + id);
        this.ajaxLoadInfo(true);
        console.log(url);
        setTimeout(function () {
            $.ajax({
                timeout: 60000,
                url: url,
                success: function (data, status) {
                    oCurrRow.removeClass("offline");
                    if (data.error) {
                        $callIcon.removeClass(spinIcon);
                        $callIcon.addClass(callIcon);
                        SYSTEM.notify(data.message, "error");
                        oCurrRow.addClass("offline");
                        _self.running = false;
                        _self.ajaxLoadInfo(false);
                        return;
                    }

                    data = data.data[0];
                    var $maintenanceMode = $("#maintenanceMode_" + id);
                    var $lastRun = $("#lastRun_" + id);
                    var $status = $("#status_" + id);


                    if (data.History.ConfigMaintenancemode == "On") {
                        $maintenanceMode.html("<i class=\"fa fa-warning\" style=\"color:#F2963F\"></i>");
                        $maintenanceMode.fadeIn("fast");
                    } else {
                        $maintenanceMode.html("<i class=\"fa fa-warning\" style=\"color:#ccc\"></i>");
                        $maintenanceMode.fadeIn("fast");
                    }

                    if (data.History.Statuscode == 200) {
                        $status.html("<i class=\"fa fa-globe fa-2x\" style=\"color:#007700\"></i> Online");
                        $status.fadeIn("fast");
                        oCurrRow.removeClass("offline");
                    } else {
                        $status.html("<i class=\"fa fa-globe fa-2x fa-blink\" style=\"color:#770000\"></i> Offline");
                        $status.fadeIn("fast");
                        oCurrRow.addClass("offline");
                    }

                    $lastRun.html(data.LastRun);
                    $lastRun.fadeIn("fast");

                    $callIcon.removeClass(spinIcon);
                    $callIcon.addClass(callIcon);
                    _self.running = false;
                    $(obj).trigger("api-call-complete", [data]);

                    $(document).trigger("api-call-row-update-" + id, [data]);

                    if (data.Statuscode != 200) {
                        console.log(data);
                        SYSTEM.openModal("/backend/remoteapp/api/error/" + data.Statuscode);
                        SYSTEM.notify(data, "error");
                    } else {
                        SYSTEM.notify("Request for \"" + data.Name + "\" successful", "success");

                    }
                    _self.ajaxLoadInfo(false);
                },
                error: function () {
                    $callIcon.removeClass(spinIcon);
                    $callIcon.addClass(callIcon);
                    _self.ajaxLoadInfo(false);
                }

            });
        }, 500);
    }
};


SYSTEM.apiCall = function (url, bReload, doNextCall, nextId, nextUrl, nextObj) {
    if (typeof bReload == "undefined") {
        bReload = false;
    }
    if (typeof doNextCall == "undefined") {
        doNextCall = false;
    }
    var _self = this;
    if (SYSTEM.confirm("Es wird eine einzelne Abfrage gestartet. Fortfahren?")) {
        $("#iApiInitDownload").remove();
        this.ajaxLoadInfo(true);
        $.ajax({
            url: url,
            success: function (data, status) {
                if (data.success) {
                    if (data.success == true) {
                        SYSTEM.notify(data.message, "success");
                        _self.ajaxLoadInfo(false);
                        if (bReload == true) {
                            setTimeout(function () {
                                document.location.reload();
                            }, 2000);
                        }
                        if (doNextCall === true) {
                            SYSTEM.runSingleApiCall(nextId, nextUrl, nextObj);
                        }
                    } else {
                        SYSTEM.notify(data.message, "error");
                        _self.ajaxLoadInfo(false);
                    }
                } else {
                    SYSTEM.notify(data.message, "error");
                    _self.ajaxLoadInfo(false);
                }
            }
        });
    }
    return false;
};


SYSTEM.runAllSingleApiCalls = function (index) {

    var buttons = $(".api_pull");
    if (!index) {
        index = 0;
    }
    if (buttons[index]) {
        $(buttons[index]).bind("api-call-complete", function (data) {
            $(document).trigger("api-call-row-update-" + data.Id, [data]);
            if (buttons[index + 1]) {
                SYSTEM.runAllSingleApiCalls((index + 1));
            }
        });
        $(buttons[index]).trigger("click");
    }

};

SYSTEM.initDownload = function (url) {
    if (SYSTEM.confirm("Wenn das Modul generiert wurde, muss dieses auch verwendet werden, da das alte damit ungültig wird. Fortfahren?")) {
        $("#iApiInitDownload").remove();
        $("body").append('<iframe id="iApiInitDownload" style="position: absolute;left:-9999px;top:-9999px;width:0;height:0" src="' + url + '"></iframe>');
        setTimeout(function () {
            $("#iApiInitDownload").remove();
        }, 60000);
    }
    return false;
};


SYSTEM.initUpdate = function (url) {
    if (SYSTEM.confirm("Sind Sie sicher das Sie das Modul aktualisieren möchten?")) {
        $("#iApiInitDownload").remove();
        $.ajax({
            url: url,
            success: function (data, status) {
                if (data.success) {
                    if (data.success == true) {
                        SYSTEM.notify(data.message, "success");
                    } else {
                        SYSTEM.notify(data.message, "error");
                    }
                } else {
                    SYSTEM.notify(data.message, "error");
                }
            }
        });
    }
    return false;
};


SYSTEM.reportBug = function () {


};


$(document).ready(function () {

    // Requires jQuery!
    jQuery.ajax({
        url: "//tickets.slash.works/s/c5101030b5338652362902ee197d6f7a-T/de_DEg081af/64020/17/1.4.25/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs.js?locale=de-DE&collectorId=f3a6db1a",
        type: "get",
        cache: true,
        dataType: "script"
    });

    window.ATL_JQ_PAGE_PROPS = {
        "triggerFunction": function (showCollectorDialog) {
            jQuery("#report_bug").click(function (e) {
                e.preventDefault();
                showCollectorDialog();
            });
        }
    };
});