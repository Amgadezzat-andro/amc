<!DOCTYPE html>

<html lang="en">

<head>
    <title></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: inherit !important;
        }

        #MessageViewBody a {
            color: inherit;
            text-decoration: none;
        }

        p {
            line-height: inherit
        }

        .desktop_hide,
        .desktop_hide table {
            mso-hide: all;
            display: none;
            max-height: 0px;
            overflow: hidden;
        }

        .image_block img+div {
            display: none;
        }

        @media (max-width:670px) {

            .desktop_hide table.icons-inner,
            .social_block.desktop_hide .social-table {
                display: inline-block !important;
            }

            .icons-inner {
                text-align: center;
            }

            .icons-inner td {
                margin: 0 auto;
            }

            .mobile_hide {
                display: none;
            }

            .row-content {
                width: 100% !important;
            }

            .stack .column {
                width: 100%;
                display: block;
            }

            .mobile_hide {
                min-height: 0;
                max-height: 0;
                max-width: 0;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide,
            .desktop_hide table {
                display: table !important;
                max-height: none !important;
            }

            .row-3 .column-1 .block-1.paragraph_block td.pad>div {
                text-align: center !important;
                font-size: 36px !important;
            }

            .row-3 .column-1 .block-1.paragraph_block td.pad,
            .row-3 .column-2 .block-1.paragraph_block td.pad {
                padding: 0 !important;
            }

            .row-3 .column-1 .block-3.spacer_block {
                height: 20px !important;
            }

            .row-3 .column-1 .block-2.paragraph_block td.pad>div {
                text-align: center !important;
                font-size: 16px !important;
            }

            .row-3 .column-2 .block-1.paragraph_block td.pad>div {
                text-align: center !important;
                font-size: 14px !important;
            }

            .row-4 .column-1 .block-3.paragraph_block td.pad>div,
            .row-7 .column-1 .block-3.paragraph_block td.pad>div {
                text-align: center !important;
            }

            .row-4 .column-1 .block-3.paragraph_block td.pad,
            .row-7 .column-1 .block-3.paragraph_block td.pad {
                padding: 5px !important;
            }

            .row-5 .column-1 .block-3.paragraph_block td.pad>div {
                font-size: 15px !important;
            }

            .row-7 .column-1 .block-2.paragraph_block td.pad>div {
                text-align: center !important;
                font-size: 32px !important;
            }

            .row-7 .column-1 .block-2.paragraph_block td.pad {
                padding: 5px 5px 0 !important;
            }

            .row-9 .column-1 .block-1.spacer_block {
                height: 40px !important;
            }

            .row-3 .column-1 {
                padding: 30px 30px 0 !important;
            }

            .row-3 .column-2 {
                padding: 0 30px !important;
            }
        }

        .social-table td img {
            width: 30px !important;
            height: 32px !important;
            border: 2px solid white !important;
            padding: 6px;
        }

        #img-logo {
            height: 153px;
            width: 250px;
        }

        .icon i {
            color: white !important;
        }
    </style><!--[if true]><style>.forceBgColor{background-color: white !important}</style><![endif]-->

</head>

<body class="body forceBgColor"
    style="background-color: transparent; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">

    <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: transparent; background-repeat: no-repeat; background-image: none; background-position: top left; background-size: auto;"
        width="100%">
        <tbody>
            <tr>
                <td>

                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-size: auto;"
                        width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                        class="row-content stack" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-radius: 0; color: #000000; background-size: auto; background-color: #ffffff; width: 650px; margin: 0 auto;"
                                        width="650">
                                        <tbody>
                                            <tr>
                                                <td class="column column-1"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                    width="100%">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        class="image_block block-1" role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        @php
                                                            use App\Models\Media\Media;

                                                            $mainlogoId = setting('en.site.logo');
                                                            if ($mainlogoId != null) {
                                                                $mainLogo = Media::find($mainlogoId);

                                                                $mainLogoPath = $mainLogo
                                                                    ? storage_path('app/public/' . $mainLogo->path)
                                                                    : null;
                                                            }

                                                        @endphp
                                                        <tr>
                                                            <td class="pad" style="width:100%;">
                                                                <div align="center" class="alignment"
                                                                    style="line-height:10px">
                                                                    <div style="max-width: 650px;">
                                                                        @if ($mainlogoId != null)
                                                                            <img alt="MainLogo" height="auto"
                                                                                src="{{ $message->embed($mainLogoPath) }}"
                                                                                style="display: block; height: auto; border: 0;"
                                                                                width="150" />
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                </td>
            </tr>
        </tbody>
    </table>


    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f5f1; border-radius: 0; color: #000000; border-left: 20px solid transparent; border-right: 20px solid transparent; border-top: 20px solid transparent; width: 650px; margin: 0 auto;"
                        width="650">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 30px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <table border="0" cellpadding="10" cellspacing="0"
                                        class="table_block mobile_hide block-1" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                        <tr>
                                            <td class="pad">
                                                <table
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; width: 100%; table-layout: fixed; direction: ltr; background-color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400; color: #222222; text-align: right; letter-spacing: 0px; word-break: break-all;"
                                                    width="100%">

                                                    <tbody
                                                        style="vertical-align: top; font-size: 14px; line-height: 120%;">

                                                        @php
                                                            $table_color = setting('admin_panel_color');
                                                        @endphp

                                                        @foreach ($mailData as $key => $item)
                                                        <tr>
                                                            <td style="background-color: {{ $table_color }}; color: #222222; font-size: 16px; font-weight: 700; padding: 10px;">
                                                                <strong>{{ ucwords(str_replace('_', ' ', $key)) }}</strong>
                                                            </td>
                                                            <td style="background-color:#f9f9f9; padding: 10px; text-align:left">
                                                                      @if (Str::startsWith($item, asset('storage/')))
                                                                        <a href="{{ $item }}" target="_blank">Download {{ ucwords(str_replace('_', ' ', $key)) }}</a>
                                                                    @else
                                                                        {!! $item !!}
                                                                    @endif

                                                            </td>
                                                        </tr>
                                                        @endforeach


                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <table border="0" cellpadding="0" cellspacing="0" class="button_block block-4"
                                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                        width="100%">
                                        <tr>
                                            <td class="pad" style="padding-top:10px;text-align:center;">
                                                <div align="center" class="alignment"><!--[if mso]>
                                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://www.example.com" style="height:38px;width:181px;v-text-anchor:middle;" arcsize="27%" stroke="false" fillcolor="#222222">
                                                    <w:anchorlock/>
                                                    <v:textbox inset="0px,0px,0px,0px">
                                                    <center dir="false" style="color:#ffffff;font-family:Arial, sans-serif;font-size:14px">
                                                    <![endif]--><a href="{{ env('APP_URL') }}"
                                                        style="background-color:#222222;border-bottom:0px solid transparent;border-left:0px solid transparent;border-radius:10px;border-right:0px solid transparent;border-top:0px solid transparent;color:#ffffff;display:inline-block;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;mso-border-alt:none;padding-bottom:5px;padding-top:5px;text-align:center;text-decoration:none;width:auto;word-break:keep-all;"
                                                        target="_blank"><span
                                                            style="word-break: break-word; padding-left: 30px; padding-right: 30px; font-size: 14px; display: inline-block; letter-spacing: 2px;"><span
                                                                style="margin: 0; word-break: break-word; line-height: 28px;">GET
                                                                IN
                                                                TOUCH</span></span></a><!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>



    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-9" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #173760; border-radius: 0; color: #000000; width: 650px; margin: 0 auto;"
                        width="650">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-left: 20px; padding-right: 20px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">

                                    <div class="spacer_block block-1"
                                        style="height:40px;line-height:40px;font-size:1px;">
                                    </div>

                                    <table border="0" cellpadding="0" cellspacing="0"
                                        class="image_block block-2" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                        <tr>
                                            @php

                                                $footerlogoId = setting('en.site.footer_logo');
                                                if ($footerlogoId != null) {
                                                    $footerLogo = Media::find($footerlogoId);

                                                    $footerLogoPath = $footerLogo
                                                        ? storage_path('app/public/' . $footerLogo->path)
                                                        : null;
                                                }

                                            @endphp
                                            <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
                                                <div align="center" class="alignment" style="line-height:10px">
                                                    <div style="max-width: 91.5px;">

                                                        @if ($footerlogoId != null)
                                                            <img alt="eisberg" height="auto"
                                                                src="{{ $message->embed($footerLogoPath) }}"
                                                                style="display: block; height: auto; border: 0;"
                                                                width="91" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table border="0" cellpadding="0" cellspacing="0"
                                        class="paragraph_block block-3" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:30px;padding-left:10px;padding-right:10px;padding-top:20px;">
                                                <div
                                                    style="color:#ffffff;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:12px;letter-spacing:2px;line-height:120%;text-align:center;mso-line-height-alt:14.399999999999999px;">
                                                    <p style="margin: 0; word-break: break-word;">
                                                        {{ setting('en.general.title') }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table border="0" cellpadding="0" cellspacing="0"
                                        class="social_block block-4" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                        <tr>
                                            <td class="pad icon"
                                                style="padding-bottom:10px;text-align:center;padding-right:0px;padding-left:0px;">
                                                <div align="center" class="alignment">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        class="social-table" role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block;"
                                                        width="168px">
                                                        <tr>
                                                            @if (setting('site.instagram_link'))
                                                                <td style="padding:0 5px 0 5px;">
                                                                    <a href="{{ setting('site.instagram_link') }}"
                                                                        target="_blank">
                                                                        <img alt="Instagram" height="auto"
                                                                            src="{{ $message->embed(public_path() . '/email_images/instgram.png') }}"
                                                                            style="display: block; height: auto; border: 0;"
                                                                            title="Instagram" width="32" />
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            @if (setting('site.facebook_link'))
                                                                <td style="padding:0 5px 0 5px;">
                                                                    <a href="{{ setting('site.facebook_link') }}"
                                                                        target="_blank">
                                                                        <img alt="Facebook" height="auto"
                                                                            src="{{ $message->embed(public_path() . '/email_images/facebook.png') }}"
                                                                            style="display: block; height: auto; border: 0;"
                                                                            title="Facebook" width="32" />
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            @if (setting('site.twitter_link'))
                                                                <td style="padding:0 5px 0 5px;">
                                                                    <a href="{{ setting('site.twitter_link') }}"
                                                                        target="_blank">
                                                                        <img alt="Twitter" height="auto"
                                                                            src="{{ $message->embed(public_path() . '/email_images/twitter.png') }}"
                                                                            style="display: block; height: auto; border: 0;"
                                                                            title="twitter" width="32" />
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            @if (setting('site.linkedin_link'))
                                                                <td style="padding:0 5px 0 5px;">
                                                                    <a href="{{ setting('site.linkedin_link') }}"
                                                                        target="_blank">
                                                                        <img alt="Linked-In" height="auto"
                                                                            src="{{ $message->embed(public_path() . '/email_images/linkedin.png') }}"
                                                                            style="display: block; height: auto; border: 0;"
                                                                            title="linkedin" width="32" />
                                                                    </a>
                                                                </td>
                                                            @endif

                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table border="0" cellpadding="10" cellspacing="0"
                                        class="paragraph_block block-5" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad">
                                                <div
                                                    style="color:#ffffff;direction:ltr;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:center;mso-line-height-alt:16.8px;">
                                                    <p style="margin: 0;">
                                                        {{ setting('en.site.address') }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                    <div class="spacer_block block-7"
                                        style="height:40px;line-height:40px;font-size:1px;">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>
