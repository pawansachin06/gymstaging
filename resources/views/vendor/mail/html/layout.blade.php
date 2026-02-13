<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style>
            @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');
    /* -------------------------------------
            GLOBAL
    ------------------------------------- */
    * {
        margin:0;
        padding:0;
    }
    * { font-family: 'Montserrat' ; }
    img{
        max-width: 100%;
        height: auto;
    }
    .collapse {
        margin:0;
        padding:0;
    }
    body {
        -webkit-font-smoothing:antialiased;
        -webkit-text-size-adjust:none;
        width: 100%!important;
        height: 100%;
        background-color: #ffffff !important;
    }
    .heading1{
        text-align: center;
        margin-bottom: 20px;
        margin-top: 2rem;
        font-weight: 600;
        color: #373736;
    }
    .link-color{
        color: #00b2bd;
        font-weight: 500;
        margin-left: 5px;
        margin-top: 15px;
        display: block;
    }



    /* -------------------------------------
            BODY
    ------------------------------------- */
    table.body-wrap { width: 100%;}


    /* -------------------------------------
            TYPOGRAPHY
    ------------------------------------- */
    h1,h2,h3,h4,h5,h6 {
        font-family: 'Montserrat';
    }
    h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #373736; line-height: 0; text-transform: none; }

    h1 { font-weight:200; font-size: 44px;}
    h2 { font-weight:200; font-size: 37px;}
    h3 { font-weight:500; font-size: 27px;}
    h4 { font-weight:500; font-size: 23px;}
    h5 { font-weight:900; font-size: 17px;}
    h6 {     font-weight: 900;}

    .collapse { margin:0!important;}

    p, ul {
        margin-bottom: 10px;
        font-weight: normal;
        font-size:18px;
        line-height:1.8;
        text-align: justify;
        color: #373736;
    }
    b{
        color: #397dcd;
        font-size: 18px;
    }

    /* ---------------------------------------------------
            RESPONSIVENESS
            Nuke it from orbit. It's the only way to be sure.
    ------------------------------------------------------ */

    /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
    .container {
        display:block!important;
        max-width:600px!important;
        margin:0 auto!important; /* makes it centered */
        clear:both!important;
    }

    /* This should also be a block element, so that it will fill 100% of the .container */
    .content {
        padding:15px;
        max-width:600px;
        margin:0 auto;
        display:block;
    }

    /* Let's make sure tables in the content area are 100% wide */
    .content table { width: 100%; }


    /* Odds and ends */
    .column {
        width: 300px;
        float:left;
    }
    .column tr td { padding: 15px; }
    .column-wrap {
        padding:0!important;
        margin:0 auto;
        max-width:600px!important;
    }
    .column table { width:100%;}
    .social .column {
        width: 280px;
        min-width: 279px;
        float:left;
    }

    /* Be sure to place a .clear element after each set of columns, just to be safe */
    .clear { display: block; clear: both; }


    /* -------------------------------------------
            PHONE
            For clients that support media queries.
            Nothing fancy.
    -------------------------------------------- */
    @media only screen and (max-width: 600px) {

        a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

        div[class="column"] { width: auto!important; float:none!important;}

        table.social div[class="column"] {
            width:auto!important;
        }
        .body-wrap h3 {
        font-size: 20px;
        }
        .body-wrap h4 {
        font-size: 18px;
        }
        p, ul {
        margin-bottom: 10px;
        font-weight: normal;
        font-size: 16px;
    }

    }

    table.head-wrap {
        width: 100%;
        border-top: 40px solid #31b0b8;
        text-align: center;
        padding-top: 10px;
    }
    .welcome-content h3{
        font-size: 20px;
        font-weight: 600;
        color: #222;
        margin-bottom: 10px;
    }
    .started-content{
        text-align: center;
        margin-top: 2rem;
    }
    .started-content h6{
        text-align: left;
        font-size: 20px !important;
        color: #00b2bd !important;
        font-weight: 600;
    }
    .started-content p{
        text-align: left;
    }
    .welcome-content h6{
        font-size: 18px;
        color: #373736;
        line-height: 25px;
        margin-top: 2rem;
    }
    .welcome-content h5{
        font-size: 18px;
        color: #373736;
        line-height: 25px;
        margin-top: 1rem;
    }
    .footer{
        width: 100%;
        background: #222;
        color: #fff;
        margin-top: 20px;
    }
    .footer p{
        text-align: center;
        color: #fff;
    }
    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }

    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>
</head>
<body bgcolor="#FFFFFF">
    {{ $header ?? '' }}


    <!-- BODY -->
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" bgcolor="#FFFFFF">

                <div class="content">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                    {{ $subcopy ?? '' }}
                </div>
            </td>
            <td></td>
        </tr>
    </table><!-- /BODY -->

    {{ $footer ?? '' }}

    {{-- <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">


                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{ $footer ?? '' }}
                </table>
            </td>
        </tr>
    </table> --}}
</body>
</html>
