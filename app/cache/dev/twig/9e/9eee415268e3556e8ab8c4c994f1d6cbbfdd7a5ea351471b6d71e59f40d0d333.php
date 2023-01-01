<?php

/* FOSUserBundle:Resetting:request_content.html.twig */
class __TwigTemplate_38c66e19f0e7e7e7ee449756c73fb8557cff172253f8c79665f3b8d086dba628 extends Twig_Template
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Resetting:request_content.html.twig"));

        // line 1
        echo "\t<h1 class=\"brand-heading\"></h1>
\t<p class=\"intro-text\">Mot de passe oublié ?</p>
<div class=\"container-full\">
      <div class=\"row\">      
        <div class=\"col-lg-12 text-center v-center\">    
\t\t<form action=\"";
        // line 6
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_resetting_send_email");
        echo "\" method=\"POST\" class=\"fos_user_resetting_request\">
\t\t\t<div>
\t\t\t\t";
        // line 8
        if ((isset($context["invalid_username"]) || array_key_exists("invalid_username", $context))) {
            // line 9
            echo "\t\t\t\t\t<p>";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("resetting.request.invalid_username", array("%username%" => ($context["invalid_username"] ?? $this->getContext($context, "invalid_username"))), "FOSUserBundle"), "html", null, true);
            echo "</p>
\t\t\t\t";
        }
        // line 11
        echo "\t\t\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <p>Saisissez votre nom d'utilisateur ou votre adresse e-mail</p>
\t\t\t\t\t\t\t\t<div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t\t\t\t\t\t\t  
\t\t\t\t\t\t\t\t  <input class=\"center-block form-control\" type=\"text\" type=\"text\" id=\"username\" name=\"username\" required=\"required\"/>
\t\t\t\t\t\t\t\t</div>   
\t\t\t\t\t\t\t</div>\t
\t\t\t\t
\t\t\t</div>
\t\t\t<div>
\t\t\t\t<button id=\"_submit\" name=\"_submit\" value=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("resetting.request.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "\" class=\"btn btn-default btn-lg\">Envoyer l'E-mail</button>
\t\t\t\t
\t\t\t</div>
\t\t</form>
\t\t</div>       
      </div> <!-- /row -->  \t
</div> 
<!-- /container full -->";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Resetting:request_content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 22,  42 => 11,  36 => 9,  34 => 8,  29 => 6,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("\t<h1 class=\"brand-heading\"></h1>
\t<p class=\"intro-text\">Mot de passe oublié ?</p>
<div class=\"container-full\">
      <div class=\"row\">      
        <div class=\"col-lg-12 text-center v-center\">    
\t\t<form action=\"{{ path('fos_user_resetting_send_email') }}\" method=\"POST\" class=\"fos_user_resetting_request\">
\t\t\t<div>
\t\t\t\t{% if invalid_username is defined %}
\t\t\t\t\t<p>{{ 'resetting.request.invalid_username'|trans({'%username%': invalid_username}, 'FOSUserBundle') }}</p>
\t\t\t\t{% endif %}
\t\t\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <p>Saisissez votre nom d'utilisateur ou votre adresse e-mail</p>
\t\t\t\t\t\t\t\t<div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t\t\t\t\t\t\t  
\t\t\t\t\t\t\t\t  <input class=\"center-block form-control\" type=\"text\" type=\"text\" id=\"username\" name=\"username\" required=\"required\"/>
\t\t\t\t\t\t\t\t</div>   
\t\t\t\t\t\t\t</div>\t
\t\t\t\t
\t\t\t</div>
\t\t\t<div>
\t\t\t\t<button id=\"_submit\" name=\"_submit\" value=\"{{ 'resetting.request.submit'|trans({}, 'FOSUserBundle') }}\" class=\"btn btn-default btn-lg\">Envoyer l'E-mail</button>
\t\t\t\t
\t\t\t</div>
\t\t</form>
\t\t</div>       
      </div> <!-- /row -->  \t
</div> 
<!-- /container full -->", "FOSUserBundle:Resetting:request_content.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\UserBundle/Resources/views/Resetting/request_content.html.twig");
    }
}
