<?php

/* BaclooCrmBundle:Crm:listemissionsemploye.html.twig */
class __TwigTemplate_228111249af49b338c52bfbcf56ce99a70b69968d40f03b79298a0e073121065 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        $this->parent = $this->loadTemplate("BaclooCrmBundle::layout.html.twig", "BaclooCrmBundle:Crm:listemissionsemploye.html.twig", 3);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "BaclooCrmBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "BaclooCrmBundle:Crm:listemissionsemploye.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 5
        echo "\t<div class=\"row clearfix\">
\t\t<div class=\"col-md-12\">
                <ul class=\"nav nav-tabs\">
                    <li class=\"active\"><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profil</h5></a></li>
                </ul>
                <div class=\"tab-content\">
                    <div class=\"tab-pane fade in active\" id=\"tab1default\">

                        ";
        // line 14
        echo "                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 22
        $context["compteur"] = 0;
        // line 23
        echo "                            <table>
                            ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missions1"] ?? $this->getContext($context, "missions1")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 25
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 26
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 6)) {
                // line 27
                echo "                                <tr>                              
                                ";
            } else {
                // line 29
                echo "                                <td width=\"550\">
                                ";
            }
            // line 30
            echo "                               
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 41
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 45
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 50
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 54
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 59
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 63
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 68
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 72
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>                              
                                    </table>
                                    </div>
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-success\" 
                                    href=\"";
            // line 78
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_postulermission", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
            echo "\">Postuler</span></a></span>
                                </div>
                                ";
            // line 80
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 4)) {
                // line 81
                echo "                                </tr>
                                
                                ";
            } else {
                // line 84
                echo "                                </td>
                                    ";
                // line 85
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 86
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 89
                echo "                                ";
            }
            // line 90
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 91
        echo "                            </table>
                            ";
        // line 93
        echo "                            </div>
                        </div>
                    </div>
                    <div class=\"tab-pane fade\" id=\"tab2default\">
                    </div>
                </div>
        </div>
\t\t<div class=\"col-md-12\">
        </div>
    </div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "BaclooCrmBundle:Crm:listemissionsemploye.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  195 => 93,  192 => 91,  186 => 90,  183 => 89,  178 => 86,  176 => 85,  173 => 84,  168 => 81,  166 => 80,  161 => 78,  152 => 72,  145 => 68,  137 => 63,  130 => 59,  122 => 54,  115 => 50,  107 => 45,  100 => 41,  92 => 36,  84 => 30,  80 => 29,  76 => 27,  73 => 26,  70 => 25,  66 => 24,  63 => 23,  61 => 22,  51 => 14,  40 => 5,  34 => 4,  11 => 3,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("
{# src/Bacloo/CrmBundle/Resources/views/Blog/search.html.twig #}
{% extends \"BaclooCrmBundle::layout.html.twig\" %}
{% block body %}
\t<div class=\"row clearfix\">
\t\t<div class=\"col-md-12\">
                <ul class=\"nav nav-tabs\">
                    <li class=\"active\"><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profil</h5></a></li>
                </ul>
                <div class=\"tab-content\">
                    <div class=\"tab-pane fade in active\" id=\"tab1default\">

                        {#Affichage mission#}                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            {% set compteur = 0 %}
                            <table>
                            {% for mission in missions1 %}
                                {% set compteur = compteur +1 %}
                                {% if compteur == 6 %}
                                <tr>                              
                                {% else %}
                                <td width=\"550\">
                                {% endif %}                               
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>{{mission.titre}}</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datedebut}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.adresse}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datefin}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.codepostal}}
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    {{mission.description}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.ville}}
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    {{mission.dresscode}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.raisonsociale}}
                                                </td>
                                            </tr>                              
                                    </table>
                                    </div>
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-success\" 
                                    href=\"{{ path('bacloocrm_postulermission', {'id': mission.id}) }}\">Postuler</span></a></span>
                                </div>
                                {% if compteur == 4 %}
                                </tr>
                                
                                {% else %}
                                </td>
                                    {% if compteur == 1 or compteur == 2 %}
                                    <td width=\"15\">
                                    </td>
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                            </table>
                            {#Fin affichage mission#}
                            </div>
                        </div>
                    </div>
                    <div class=\"tab-pane fade\" id=\"tab2default\">
                    </div>
                </div>
        </div>
\t\t<div class=\"col-md-12\">
        </div>
    </div>
{% endblock %}", "BaclooCrmBundle:Crm:listemissionsemploye.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\CrmBundle/Resources/views/Crm/listemissionsemploye.html.twig");
    }
}
