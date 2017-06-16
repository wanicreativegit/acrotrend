(function ($, root, undefined) {


    $(function () {

        'use strict';

        var services_item = $('.s__item');


        document.addEventListener('touchstart', function addtouchclass(e){ // first time user touches the screen
            document.documentElement.classList.add('can-touch') // add "can-touch" class to document root using classList API
            document.removeEventListener('touchstart', addtouchclass, false) // de-register touchstart event
        }, false);

        /**
         * service menu
         */
        $('.plus-minus-toggle').on('click', function () {
            $(this).toggleClass('collapsed');
        });

        /**
         * hamburger menu
         */

        $('.hamburger-bg').on('click', function () {
            var menuclass = $('.burger-menu');

            $(menuclass).toggleClass("burger-menu--opened");
            $(menuclass).toggleClass("burger-menu--closed");
            $('.main-menu').toggleClass('active');

            $('.service-menu-button').addClass('collapsed');
            $('.service-menu').removeClass('active');

            $('.share').removeClass('active');
            $('.contacts').removeClass('active');

        });

        /**
         * magic link
         */

        $('.magic-click').on('click', function () {
            var url = $(this).data('url');
            var type = $(this).data('type');

            if (type === '_blank') {
                window.open(url, '_blank');
            } else {
                window.location = url;
            }
        });

        /**
         * equal height
         */
        var matchHeight = function () {

            function init() {
                eventListeners();
                matchHeight();
            }

            function eventListeners() {
                $(window).on('resize', function () {
                    matchHeight();
                });
            }

            function matchHeight() {
                var groupName = $('[data-match-height]');
                var groupHeights = [];

                groupName.css('min-height', 'auto');

                groupName.each(function () {
                    groupHeights.push($(this).outerHeight());
                });

                var maxHeight = Math.max.apply(null, groupHeights);
                groupName.css('min-height', maxHeight);
            };

            return {
                init: init
            };

        }();

        $(document).ready(function () {
            matchHeight.init();
        });

        /**
         * scroll to div
         */

        $(".scroll-button").click(function () {
            var idi = $(this).data('id');
            $('html, body').animate({
                scrollTop: $("#" + idi).offset().top
            }, 500);
        });

        /**
         * slider
         */

        $('.slider').each(function (index) {
            $(this).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 4000,
                arrows: false,
                dots: true
            });

            $(this).on('afterChange', function (event, slick, currentSlide, nextSlide) {

                var image = $(this).find('.slick-current').data('image');
                $('.bg-image').css('background-image', 'url(' + image + ')');

            });
        });


        $('.service-menu-button').click(function(){

            $('.service-menu').toggleClass('active');

            var menuclass = $('.burger-menu');

            $(menuclass).removeClass("burger-menu--opened");
            $(menuclass).addClass("burger-menu--closed");
            $('.main-menu').removeClass('active');

            $('.share').toggleClass('active');
            $('.contacts').toggleClass('active');

        });


        $('.job-label').click(function () {

            $('.job-label').removeClass('active');
            $(this).addClass('active');

        });


        $('.big-button').on('click', function () {

            var target = $(this).find("a").attr("href");
            window.location = target;

        });


        $('.job_radio').on("change", function () {
            var ac = $(this).val();
            console.log(ac);
            $('#role_type').val(ac);
        });


        var image_2 = 'icon';

        services_item.each(function () {
            $(this).find('.image').css("background-image", "url(" + $(this).find('.image').data('icon') + ")");
        });

        $('.close').click(function () {
            $('.cat-button').removeClass('active');
            $('.content').removeClass('active');

            image_2='icon'

            $('.service').each(function(){
                $(this).removeClass('hide_please');
            });

            services_item.each(function () {

                $(this).find('.image').css("background-image", "url(" + $(this).find('.image').data('icon') + ")");
                $(this).find('.content').find('p').removeClass('active');
                $(this).find('.content').find('#main').addClass('active');

            });
        });


        $('.cat-button').click(function (e) {
            e.preventDefault();


            var slug = $(this).data('slug');

            services_item.each(function () {
                $(this).attr('class', 's__item');
                $(this).find('.image').css("background-image", "url(" + $(this).find('.image').data(slug) + ")");
            });

            $('.service').each(function(){
                $(this).removeClass('hide_please');
            });

            image_2=slug;

            var idi = $(this).data('id');

            $('.cat-button').removeClass('active');
            $('.content').removeClass('active');

            $(this).addClass('active');
            $('#cat-' + idi).addClass('active');

            $('.service').each(function(){

                if(!$(this).hasClass(slug)){
                    $(this).addClass('hide_please');
                }

            });

            services_item.each(function () {

                $(this).addClass('active-' + idi);
                $(this).find('.content').find('p').removeClass('active');
                $(this).find('.content').find('#'+slug).addClass('active');
                $(this).find('.image').addClass('active');

            });
        });


        services_item.each(function () {
            $(this).find('.image').css("background-image", "url(" + $(this).find('.image').data('icon') + ")");
        });



        services_item.hover(function () {
                $(this).find('.image').css("background-image", "url(" + $(this).find('.image').data('active') + ")");
            },
            function () {
                $(this).find('.image').css("background-image", "url(" + $(this).find('.image').data(image_2) + ")");
            }
        );




        $('.multiple-items').slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            arrows: false,
            dots: false,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });


        if ( $(window).width() > 739) {

            $('.services-items').slick({
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                arrows: false,
                dots: false,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });

        }


        $('.magic').slick({
            centerMode: true,
            centerPadding: '200px',
            slidesToShow: 3,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });


        $('.file-150').append($('<span>Upload CV*</span>'));


            $(".wpcf7-file").change(function() {
                var filename = readURL(this);
                $(this).parent().children('span').html(filename);
            });

            // Read File and return value
            function readURL(input) {
                var url = input.value;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (
                    ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "gif" || ext == "pdf" || ext == "doc" || ext == "docx"
                    )) {
                    var path = $(input).val();
                    var filename = path.replace(/^.*\\/, "");
                    // $('.fileUpload span').html('Uploaded Proof : ' + filename);
                    return "Uploaded file : "+filename;
                } else {
                    $(input).val("");
                    return "Only pdf/doc/docx formats are allowed!";
                }
            }




// Grab data attributes from video-wrapper
        var videoID = $(".video-wrapper").data("video-id");
        var videoYouTubeLink = $(".video-wrapper").data("video-youtube-link");
        var videoStart = $(".video-wrapper").data("video-start");
        var videoEnd = $(".video-wrapper").data("video-end");
        var videoWidthAdd = $(".video-wrapper").data("video-width-add");
        var videoHeightAdd = $(".video-wrapper").data("video-height-add");

// Create video script element
        var tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/player_api';
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// Setup the Youtube TV with player defaults
        var tv,
            playerDefaults = {
                autoplay: 0,
                autohide: 1,
                modestbranding: 1,
                rel: 0,
                showinfo: 0,
                controls: 0,
                disablekb: 1,
                enablejsapi: 0,
                iv_load_policy: 3
            };
        var vid = {'videoId': videoID, 'startSeconds': videoStart, 'endSeconds': videoEnd, 'suggestedQuality': 'hd720'};

        function onYouTubePlayerAPIReady() {
            tv = new YT.Player('tv', {
                events: {'onReady': onPlayerReady, 'onStateChange': onPlayerStateChange},
                playerVars: playerDefaults
            });
        }

        function onPlayerReady() {
            tv.loadVideoById(vid);
            tv.mute();
        }

        function onPlayerStateChange(e) {
            if (e.data === 1) {
                $('#tv').addClass('active');
            } else if (e.data === 0) {
                tv.seekTo(vid.startSeconds)
            }
        }

        /*
        separate emails to different applicants
         */
        var curr_cat_email = $("#curr_cat").val();
        $('#send-to-email').val(curr_cat_email);

        var curr_title = $("#role_name").val();
        $('#role_type').val(curr_title);


        function vidRescale() {
            var w = $(window).width() + videoWidthAdd,
                h = $(window).height() + videoHeightAdd;
            if (w / h > 16 / 9) {
                tv.setSize(w, w / 16 * 9);
                $('.tv .screen').css({'left': '0px'});
            } else {
                tv.setSize(h / 9 * 16, h);
                $('.tv .screen').css({'left': -($('.tv .screen').outerWidth() - w) / 2});
            }
        }


        $(window).on('load resize', function () {
            vidRescale();
        });



    });

})(jQuery, this);
