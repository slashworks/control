$(function () {

    $('#side-menu').metisMenu();

});

$(function () {
    $(window).bind("load resize", function () {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    $('.head-controls, .table-responsive, .panel-body, .datatable').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

});


var SystemApp = function () {

    this.modalWindow = {};
    this.running = false;
    this.init = function () {
        $("#iApiInitDownload").remove();
    };

    this.ajaxLoadInfo = function(show){
        if(show){
            $("#ajax-loader").show();
        }else{
            $("#ajax-loader").hide();
        }
    };

    this.modal = function(url,title, modal_class){
        if(typeof modal_class == "undefined"){
            modal_class = "modal-lg";
        }
        var system = this;
        var d = new Date().getTime(), id = 'modal-'+ d,c = this.modalWindow.clone().attr('id',id).appendTo('body');
        c.on('loaded.bs.modal', function (e) {

            c.unbind('loaded.bs.modal');
            if(modal_class != "modal-sm"){
                $('#'+id+' .modal-dialog').switchClass( 'modal-sm', modal_class, 400, 'easeInOutQuad' );
            }
            setTimeout(function(){
                $('#'+id+' #modal-body-wrapper').fadeTo('fast',1);
            },410);
        });
        c.on('hidden.bs.modal', function (e) {
            c.unbind('hidden.bs.modal');
            $('#'+id).remove();
            System.modalIds.pop();
        });
        c.on('show.bs.modal', function (e) {
            c.unbind('show.bs.modal');
            $('#'+id+' .modal-content').html('');
            $('#modal-content-preset').children().clone().appendTo('#'+id+' .modal-content');
            $('#'+id+' .modal-content .progress-striped').addClass('active');
        });
        c.on('shown.bs.modal', function (e) {
            c.unbind('shown.bs.modal');
            System.resetLogoutTimer();
            system.initAjaxLinks('#'+id+' .modal-content ');
        });
        c.modal({remote:url});
        return false;
    };

    this.openModal = function (url, modal_class) {

        if(typeof modal_class == "undefined"){
            modal_class = "modal-lg";
        }

        $.ajax({
            url: url,
            success: function (data, status) {
                var m = $(data).modal();
                m.on("hidden.bs.modal",function(){
                    $(".modal").remove();
                });
            }
        });
    };

    this.confirm = function(msg){
        //@todo hübsch machen
        return confirm(msg);
    };


    this.notify = function(msg, type){
        if(typeof type == "undefined"){
            type = "info";
        }

        if(type == "error"){
            type = "danger";
        }

        $.growl({
            message: " "+msg
        },{
            type: type,
            delay:30000,
            placement:{
                from:"top",
                align:"right"
            },
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
        });

        $(".growl-animated").css("z-index",10000000000);

    };



};

var SYSTEM = new SystemApp();
SYSTEM.init();