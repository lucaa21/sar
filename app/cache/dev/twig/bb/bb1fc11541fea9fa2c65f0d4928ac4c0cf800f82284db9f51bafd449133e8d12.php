<?php

/* FOSUserBundle:Registration:register_content.html.twig */
class __TwigTemplate_b178e22012e7d0054f2c76108bde54abd6f4ee25593e1c8af08153c763c1abb0 extends Twig_Template
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Registration:register_content.html.twig"));

        // line 1
        echo "\t<h1 class=\"brand-heading\">";
        echo twig_escape_filter($this->env, ($context["societe"] ?? $this->getContext($context, "societe")), "html", null, true);
        echo "</h1>

<div class=\"container-full\">
      <div class=\"row\">      
        <div class=\"col-lg-12 text-center v-center\"> 
\t
\t\t\t<form  role=\"form\" class=\"form-horizontal\" action=\"";
        // line 7
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_registration_register");
        echo "\" ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'enctype');
        echo " method=\"POST\" class=\"fos_user_registration_register\">
\t\t\t\t<fieldset>
\t\t\t\t";
        // line 9
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'errors');
        echo "
\t\t\t\t<div class=\"hidden\">";
        // line 10
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "usersociete", array()), 'widget', array("value" => ($context["societe"] ?? $this->getContext($context, "societe"))));
        echo "</div>
\t\t\t\t<div class=\"hidden\">";
        // line 11
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "nomrep", array()), 'widget', array("value" => ($context["society"] ?? $this->getContext($context, "society"))));
        echo "</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t
\t\t\t\t\t\t\t  <span class=\"input-group-addon info info\"><span class=\"glyphicon glyphicon-user\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  ";
        // line 16
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "username", array()), 'widget', array("attr" => array("class" => "center-block form-control input-lg", "placeholder" => "Nom d'utilisateur")));
        echo "
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t";
        // line 18
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "username", array()), 'errors');
        echo "\t\t\t\t\t\t  
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">

\t\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  ";
        // line 25
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "email", array()), 'widget', array("attr" => array("class" => "center-block form-control input-lg", "placeholder" => "E-mail")));
        echo "\t\t\t\t\t\t\t\t
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t  ";
        // line 27
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "email", array()), 'errors');
        echo "
\t\t\t\t\t\t</div>ss

\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">

\t\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-lock\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  ";
        // line 34
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "first", array()), 'widget', array("attr" => array("class" => "center-block form-control input-lg", "placeholder" => "Mot de passe")));
        echo "
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t";
        // line 36
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "first", array()), 'errors');
        echo "\t\t\t\t\t\t  
\t\t\t\t\t\t</div> 

\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">

\t\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-lock\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  ";
        // line 43
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "second", array()), 'widget', array("attr" => array("class" => "center-block form-control input-lg", "placeholder" => "Retapez votre mot de passe")));
        echo "
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t";
        // line 45
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "second", array()), 'errors');
        echo "\t\t\t\t\t\t  
\t\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<br><button id=\"_submit\" name=\"_submit\"  class=\"btn btn-default btn-lg\" type=\"submit\" value=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "\" class=\"btn btn-lg btn-primary active\">S'enregistrer</button>
\t\t\t\t\t\t</div>\t\t
\t\t\t\t</fieldset>
";
        // line 51
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "_token", array()), 'row');
        echo "\t\t\t\t
\t\t\t</form>
        </div>       
      </div> <!-- /row --> 
</div> <!-- /container full -->
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Registration:register_content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 51,  111 => 48,  105 => 45,  100 => 43,  90 => 36,  85 => 34,  75 => 27,  70 => 25,  60 => 18,  55 => 16,  47 => 11,  43 => 10,  39 => 9,  32 => 7,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("\t<h1 class=\"brand-heading\">{{ societe }}</h1>

<div class=\"container-full\">
      <div class=\"row\">      
        <div class=\"col-lg-12 text-center v-center\"> 
\t
\t\t\t<form  role=\"form\" class=\"form-horizontal\" action=\"{{ path('fos_user_registration_register') }}\" {{ form_enctype(form) }} method=\"POST\" class=\"fos_user_registration_register\">
\t\t\t\t<fieldset>
\t\t\t\t{{ form_errors(form) }}
\t\t\t\t<div class=\"hidden\">{{ form_widget(form.usersociete, { 'value' : societe }) }}</div>
\t\t\t\t<div class=\"hidden\">{{ form_widget(form.nomrep, { 'value' : society }) }}</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t
\t\t\t\t\t\t\t  <span class=\"input-group-addon info info\"><span class=\"glyphicon glyphicon-user\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  {{ form_widget(form.username, { 'attr' : { 'class' : 'center-block form-control input-lg', 'placeholder' : 'Nom d\\'utilisateur'  } })  }}
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t{{ form_errors(form.username) }}\t\t\t\t\t\t  
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">

\t\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  {{ form_widget(form.email, { 'attr' : { 'class' : 'center-block form-control input-lg', 'placeholder' : 'E-mail' } })  }}\t\t\t\t\t\t\t\t
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t  {{ form_errors(form.email) }}
\t\t\t\t\t\t</div>ss

\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">

\t\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-lock\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  {{ form_widget(form.plainPassword.first, { 'attr' : { 'class' : 'center-block form-control input-lg', 'placeholder' : 'Mot de passe'  } })  }}
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t{{ form_errors(form.plainPassword.first) }}\t\t\t\t\t\t  
\t\t\t\t\t\t</div> 

\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t  <div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">

\t\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-lock\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t\t  {{ form_widget(form.plainPassword.second, { 'attr' : { 'class' : 'center-block form-control input-lg', 'placeholder' : 'Retapez votre mot de passe'  } })  }}
\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t{{ form_errors(form.plainPassword.second) }}\t\t\t\t\t\t  
\t\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<br><button id=\"_submit\" name=\"_submit\"  class=\"btn btn-default btn-lg\" type=\"submit\" value=\"{{ 'registration.submit'|trans({}, 'FOSUserBundle') }}\" class=\"btn btn-lg btn-primary active\">S'enregistrer</button>
\t\t\t\t\t\t</div>\t\t
\t\t\t\t</fieldset>
{{ form_row(form._token) }}\t\t\t\t
\t\t\t</form>
        </div>       
      </div> <!-- /row --> 
</div> <!-- /container full -->
", "FOSUserBundle:Registration:register_content.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\UserBundle/Resources/views/Registration/register_content.html.twig");
    }
}
