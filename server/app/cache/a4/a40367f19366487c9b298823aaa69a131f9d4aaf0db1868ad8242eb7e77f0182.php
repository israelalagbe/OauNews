<?php

/* form.html */
class __TwigTemplate_8e99c62984b6a019995738a64dada3932535ddf8c101df1e18e75f2dd1241eea extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<title>Form Style 8</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<script type=\"text/javascript\">
//auto expand textarea
function adjust_textarea(h) {
    h.style.height = \"45px\";
    h.style.height = (h.scrollHeight)+\"px\";
}
</script>
<style>
body{
\tbackground: #348A96;
}
.form-style-8{
\tfont-family: 'Open Sans Condensed', arial, sans;
\twidth: 500px;
\tpadding: 30px;
\tbackground: #FFFFFF;
\tmargin: 50px auto;
\tbox-shadow: 0px 0px 15px rgba(0, 0, 0, 0.22);
\t-moz-box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.22);
\t-webkit-box-shadow:  0px 0px 15px rgba(0, 0, 0, 0.22);

}
.form-style-8 h2{
\tbackground: #4D4D4D;
\ttext-transform: uppercase;
\tfont-family: 'Open Sans Condensed', sans-serif;
\tcolor: #797979;
\tfont-size: 18px;
\tfont-weight: 100;
\tpadding: 20px;
\tmargin: -30px -30px 30px -30px;
}
.form-style-8 input[type=\"text\"],
.form-style-8 input[type=\"file\"],
.form-style-8 input[type=\"date\"],
.form-style-8 input[type=\"datetime\"],
.form-style-8 input[type=\"email\"],
.form-style-8 input[type=\"number\"],
.form-style-8 input[type=\"search\"],
.form-style-8 input[type=\"time\"],
.form-style-8 input[type=\"url\"],
.form-style-8 input[type=\"password\"],
.form-style-8 textarea,
.form-style-8 select 
{
\tbox-sizing: border-box;
\t-webkit-box-sizing: border-box;
\t-moz-box-sizing: border-box;
\toutline: none;
\tdisplay: block;
\twidth: 100%;
\tpadding: 7px;
\tborder: none;
\tborder-bottom: 1px solid #ddd;
\tbackground: transparent;
\tmargin-bottom: 10px;
\tfont: 16px Arial, Helvetica, sans-serif;
\theight: 45px;
}
.form-style-8 input[type=\"file\"]{
\tdisplay:inline-block;
}
.form-style-8 textarea{
\tresize:none;
\toverflow: hidden;
}
.form-style-8 input[type=\"button\"], 
.form-style-8 input[type=\"submit\"]{
\t-moz-box-shadow: inset 0px 1px 0px 0px #45D6D6;
\t-webkit-box-shadow: inset 0px 1px 0px 0px #45D6D6;
\tbox-shadow: inset 0px 1px 0px 0px #45D6D6;
\tbackground-color: #2CBBBB;
\tborder: 1px solid #27A0A0;
\tdisplay: inline-block;
\tcursor: pointer;
\tcolor: #FFFFFF;
\tfont-family: 'Open Sans Condensed', sans-serif;
\tfont-size: 14px;
\tpadding: 8px 18px;
\ttext-decoration: none;
\ttext-transform: uppercase;
}
.form-style-8 input[type=\"button\"]:hover, 
.form-style-8 input[type=\"submit\"]:hover {
\tbackground:linear-gradient(to bottom, #34CACA 5%, #30C9C9 100%);
\tbackground-color:#34CACA;
}
</style>
</head>

<body>

<div class=\"form-style-8\">
  <h2>New News</h2>
  <form>
    <input type=\"text\" name=\"field1\" placeholder=\"Title\" />
    <input type=\"email\" name=\"field2\" placeholder=\"Author\" />
    <div>
\t\t<img id='img' src='' height='200' />
\t</div>
    <input type=\"file\" id='file' name=\"field1\" onchange=\"preview()\"  />
    <input type=\"url\" name=\"field3\" placeholder=\"Website\" />
    <textarea placeholder=\"Message\" onkeyup=\"adjust_textarea(this)\"></textarea>
    <input type=\"button\" value=\"Send Message\" />
  </form>
</div>
<script type=\"text/javascript\">
\tfunction preview(){
\t\tvar img=document.querySelector('#img');
\t\tvar file=document.querySelector('#file').files[0];
\t\tvar reader=new FileReader();
\t\treader.addEventListener('load',function(){
\t\t\timg.src=reader.result;
\t\t},false);
\t\tif (file)
\t\t\treader.readAsDataURL(file);
\t}
</script>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "form.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "form.html", "C:\\xampp\\htdocs\\jerry\\server\\app\\template\\form.html");
    }
}
