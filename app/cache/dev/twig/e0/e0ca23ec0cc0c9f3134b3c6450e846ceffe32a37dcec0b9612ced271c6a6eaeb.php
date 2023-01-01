<?php

/* BaclooCrmBundle:Crm:listemissionsagence.html.twig */
class __TwigTemplate_16af90dfe666789cd0d8ef04ae0422e3e0ecc35ab788add636a0d44bc47d800e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        $this->parent = $this->loadTemplate("BaclooCrmBundle::layout.html.twig", "BaclooCrmBundle:Crm:listemissionsagence.html.twig", 3);
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "BaclooCrmBundle:Crm:listemissionsagence.html.twig"));

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
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                </ul>
                <div class=\"tab-content\">
                    <div class=\"tab-pane fade in active\" id=\"tab1default\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Nouvelle mission
                                </h3>
                            </div>
                            ";
        // line 20
        echo "                            <div class=\"panel-body\">   
                                <form class=\"form-horizontal\" action=\"";
        // line 21
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_listemissionsagence");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'enctype');
        echo ">
                                    <fieldset>
                                        <div class=\"col-md-6 column\">
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Titre</span>
                                                            ";
        // line 28
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "titre", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date début</span>
                                                            ";
        // line 36
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "datedebut", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date fin</span>
                                                            ";
        // line 44
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "datefin", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Adresse</span>
                                                            ";
        // line 52
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "adresse", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Dresscode</span>
                                                            ";
        // line 60
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "dresscode", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>
                                        <div class=\"col-md-6 column\">
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Raison sociale</span>
                                                        ";
        // line 70
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "raisonsociale", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                    </div>    
                                                </div>
                                            </div>
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Description</span>
                                                        ";
        // line 78
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "description", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                    </div>    
                                                </div>
                                            </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Code postal</span>
                                                            ";
        // line 86
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "codepostal", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Ville</span>
                                                            ";
        // line 94
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "ville", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Urgent (0/1)</span>
                                                            ";
        // line 102
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "urgent", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>                        
                                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Enregistrer\"/>
                                    </div>\t\t
                                ";
        // line 109
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "_token", array()), 'row');
        echo "\t
                                </fieldset>
                                </form>
                            ";
        // line 113
        echo "                            </div>
                        </div> 

                            ";
        // line 116
        echo "                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 124
        $context["compteur"] = 0;
        // line 125
        echo "                            <table>
                            ";
        // line 126
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missions1"] ?? $this->getContext($context, "missions1")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 127
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 128
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 6)) {
                // line 129
                echo "                                <tr>                              
                                ";
            } else {
                // line 131
                echo "                                <td width=\"550\">
                                ";
            }
            // line 132
            echo "                               
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 138
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 143
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 147
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 152
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 156
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 161
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 165
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 170
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 174
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>                              
                                    </table>
                                    </div>
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                    href=\"";
            // line 180
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_removemission", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
            echo "\">Supprimer</span></a></span>
                                </div>
                                ";
            // line 182
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 4)) {
                // line 183
                echo "                                </tr>
                                
                                ";
            } else {
                // line 186
                echo "                                </td>
                                    ";
                // line 187
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 188
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 191
                echo "                                ";
            }
            // line 192
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 193
        echo "                            </table>
                            ";
        // line 195
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
        return "BaclooCrmBundle:Crm:listemissionsagence.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  337 => 195,  334 => 193,  328 => 192,  325 => 191,  320 => 188,  318 => 187,  315 => 186,  310 => 183,  308 => 182,  303 => 180,  294 => 174,  287 => 170,  279 => 165,  272 => 161,  264 => 156,  257 => 152,  249 => 147,  242 => 143,  234 => 138,  226 => 132,  222 => 131,  218 => 129,  215 => 128,  212 => 127,  208 => 126,  205 => 125,  203 => 124,  193 => 116,  188 => 113,  182 => 109,  172 => 102,  161 => 94,  150 => 86,  139 => 78,  128 => 70,  115 => 60,  104 => 52,  93 => 44,  82 => 36,  71 => 28,  59 => 21,  56 => 20,  40 => 5,  34 => 4,  11 => 3,);
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
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                </ul>
                <div class=\"tab-content\">
                    <div class=\"tab-pane fade in active\" id=\"tab1default\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Nouvelle mission
                                </h3>
                            </div>
                            {#Formulaire saisie mission#}
                            <div class=\"panel-body\">   
                                <form class=\"form-horizontal\" action=\"{{ path('bacloocrm_listemissionsagence') }}\" method=\"post\" {{form_enctype(form) }}>
                                    <fieldset>
                                        <div class=\"col-md-6 column\">
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Titre</span>
                                                            {{ form_widget(form.titre, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date début</span>
                                                            {{ form_widget(form.datedebut, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date fin</span>
                                                            {{ form_widget(form.datefin, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Adresse</span>
                                                            {{ form_widget(form.adresse, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Dresscode</span>
                                                            {{ form_widget(form.dresscode, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>
                                        <div class=\"col-md-6 column\">
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Raison sociale</span>
                                                        {{ form_widget(form.raisonsociale, { 'attr' : { 'class' : 'form-control' } })  }}
                                                    </div>    
                                                </div>
                                            </div>
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Description</span>
                                                        {{ form_widget(form.description, { 'attr' : { 'class' : 'form-control' } })  }}
                                                    </div>    
                                                </div>
                                            </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Code postal</span>
                                                            {{ form_widget(form.codepostal, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Ville</span>
                                                            {{ form_widget(form.ville, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Urgent (0/1)</span>
                                                            {{ form_widget(form.urgent, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>                        
                                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Enregistrer\"/>
                                    </div>\t\t
                                {{ form_row(form._token) }}\t
                                </fieldset>
                                </form>
                            {#Fin formulaire saisie mission#}
                            </div>
                        </div> 

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
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                    href=\"{{ path('bacloocrm_removemission', {'id': mission.id}) }}\">Supprimer</span></a></span>
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
{% endblock %}", "BaclooCrmBundle:Crm:listemissionsagence.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\CrmBundle/Resources/views/Crm/listemissionsagence.html.twig");
    }
}
