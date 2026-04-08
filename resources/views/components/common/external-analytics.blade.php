

    @if(setting("general.google_analytics_code"))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('general.google_analytics_code') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', "{{ setting('general.google_analytics_code') }}");
        </script>
        <!-- End Global site tag (gtag.js) - Google Analytics -->
    @endif






    @if(setting("general.google_tag_code"))
        <!-- Google Tag Manager (noscript) -->
            <noscript>
                <iframe src="https://www.googletagmanager.com/ns.html?id={{setting('general.google_tag_code')}}" height="0" width="0" class="d-none" >
                </iframe>
            </noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif



    @if(setting("general.meta_pixel_code"))
        <!-- Meta Pixel Code -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{setting("general.meta_pixel_code")}}');
            fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" class="d-none" src="https://www.facebook.com/tr?id={{setting('general.meta_pixel_code')}}&ev=PageView&noscript=1" /></noscript>
        <!-- End Meta Pixel Code -->
    @endif


    @if(setting("general.clarity_code"))
        <!-- Clarity Code -->
        <script>
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", {{setting("general.clarity_code")}});

        </script>
        <!-- End Clarity Code -->
    @endif


    @if(setting("general.hotjar_code"))
        <!-- Hot Jar Code -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:{{ setting("general.hotjar_code") }},hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');

        </script>
        <!-- End Hot Jar Code -->
    @endif
