<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);

        if (0 === strpos($pathinfo, '/_')) {
            if (0 === strpos($pathinfo, '/_console/_console')) {
                // console
                if ('/_console/_console' === $pathinfo) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_console;
                    }

                    return array (  '_controller' => 'coresphere_console.controller:consoleAction',  '_route' => 'console',);
                }
                not_console:

                // console_exec
                if (0 === strpos($pathinfo, '/_console/_console/commands') && preg_match('#^/_console/_console/commands(?:\\.(?P<_format>json))?$#sD', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_console_exec;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'console_exec')), array (  '_controller' => 'coresphere_console.controller:execAction',  '_format' => 'json',));
                }
                not_console_exec:

            }

            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === rtrim($pathinfo, '/')) {
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                        goto not__profiler_home;
                    } else {
                        return $this->redirect($rawPathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }
                not__profiler_home:

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ('/_profiler/purge' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if ('/_configurator' === rtrim($pathinfo, '/')) {
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                        goto not__configurator_home;
                    } else {
                        return $this->redirect($rawPathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }
                not__configurator_home:

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ('/_configurator/final' === $pathinfo) {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        // bacloopayment_buy_credits
        if ('/acheter_des_credits' === $pathinfo) {
            return array (  '_controller' => 'Bacloo\\PaymentBundle\\Controller\\PaymentController::preparePaypalExpressCheckoutPaymentAction',  '_route' => 'bacloopayment_buy_credits',);
        }

        // bacloocrm_paiement
        if ('/paiement_ok' === $pathinfo) {
            return array (  '_controller' => 'Bacloo\\PaymentBundle\\Controller\\PaymentController::doneAction',  '_route' => 'bacloocrm_paiement',);
        }

        // bacloocrm_accueil
        if ('' === rtrim($pathinfo, '/')) {
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                goto not_bacloocrm_accueil;
            } else {
                return $this->redirect($rawPathinfo.'/', 'bacloocrm_accueil');
            }

            return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'bacloocrm_accueil',);
        }
        not_bacloocrm_accueil:

        // bacloocrm_home
        if ('/accueil' === $pathinfo) {
            return array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::accueilAction',  '_route' => 'bacloocrm_home',);
        }

        if (0 === strpos($pathinfo, '/liste_des_missions_')) {
            // bacloocrm_agence
            if (0 === strpos($pathinfo, '/liste_des_missions_agence') && preg_match('#^/liste_des_missions_agence(?:/(?P<onglet>[^/]++)(?:/(?P<nom>[^/]++))?)?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'bacloocrm_agence')), array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::agenceAction',  'onglet' => 'missions',  'nom' => 0,));
            }

            // bacloocrm_employe
            if ('/liste_des_missions_employe' === rtrim($pathinfo, '/')) {
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                    goto not_bacloocrm_employe;
                } else {
                    return $this->redirect($rawPathinfo.'/', 'bacloocrm_employe');
                }

                return array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::employeAction',  '_route' => 'bacloocrm_employe',);
            }
            not_bacloocrm_employe:

        }

        // bacloocrm_removemission
        if (0 === strpos($pathinfo, '/supprimer_mission') && preg_match('#^/supprimer_mission/(?P<id>[^/]++)(?:/(?P<check>[^/]++))?$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'bacloocrm_removemission')), array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::removemissionAction',  'check' => 0,));
        }

        // bacloocrm_postulermission
        if (0 === strpos($pathinfo, '/postuler_mission') && preg_match('#^/postuler_mission/(?P<id>[^/]++)(?:/(?P<check>[^/]++))?$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'bacloocrm_postulermission')), array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::postulermissionAction',  'check' => 0,));
        }

        // bacloocrm_acceptercandidature
        if (0 === strpos($pathinfo, '/accepter_candidature') && preg_match('#^/accepter_candidature/(?P<id>[^/]++)(?:/(?P<check>[^/]++))?$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'bacloocrm_acceptercandidature')), array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::acceptercandidatureAction',  'check' => 0,));
        }

        // bacloocrm_refusercandidature
        if (0 === strpos($pathinfo, '/refuser_candidature') && preg_match('#^/refuser_candidature/(?P<id>[^/]++)(?:/(?P<check>[^/]++))?$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'bacloocrm_refusercandidature')), array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::refusercandidatureAction',  'check' => 0,));
        }

        // bacloocrm_profilsagence
        if ('/profils' === rtrim($pathinfo, '/')) {
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                goto not_bacloocrm_profilsagence;
            } else {
                return $this->redirect($rawPathinfo.'/', 'bacloocrm_profilsagence');
            }

            return array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::profilsagenceAction',  '_route' => 'bacloocrm_profilsagence',);
        }
        not_bacloocrm_profilsagence:

        // bacloocrm_dropzone
        if (0 === strpos($pathinfo, '/dropzone') && preg_match('#^/dropzone(?:/(?P<codedocument>[^/]++)(?:/(?P<type>[^/]++))?)?$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'bacloocrm_dropzone')), array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::dropzoneAction',  'codedocument' => 0,  'type' => 0,));
        }

        if (0 === strpos($pathinfo, '/conditions_generales')) {
            // bacloocrm_conditions_generales
            if ('/conditions_generales' === $pathinfo) {
                return array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::conditionsAction',  '_route' => 'bacloocrm_conditions_generales',);
            }

            // bacloocrm_conditions_generales_public
            if ('/conditions_generales_utilisation' === $pathinfo) {
                return array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::conditionspubAction',  '_route' => 'bacloocrm_conditions_generales_public',);
            }

        }

        // bacloocrm_removedocument
        if (0 === strpos($pathinfo, '/removedocument') && preg_match('#^/removedocument/(?P<iddoc>[^/]++)/(?P<codedocument>[^/]++)/(?P<type>[^/]++)$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'bacloocrm_removedocument')), array (  '_controller' => 'Bacloo\\CrmBundle\\Controller\\CrmController::removedocumentAction',  'codedocument' => 0,));
        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ('/login' === $pathinfo) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ('/login_check' === $pathinfo) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ('/logout' === $pathinfo) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if ('/profile' === rtrim($pathinfo, '/')) {
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                    goto not_fos_user_profile_show;
                } else {
                    return $this->redirect($rawPathinfo.'/', 'fos_user_profile_show');
                }

                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ('/profile/edit' === $pathinfo) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/registerok')) {
                // fos_user_registration_register
                if ('/registerok' === rtrim($pathinfo, '/')) {
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                        goto not_fos_user_registration_register;
                    } else {
                        return $this->redirect($rawPathinfo.'/', 'fos_user_registration_register');
                    }

                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_registration_register;
                    }

                    return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }
                not_fos_user_registration_register:

                if (0 === strpos($pathinfo, '/registerok/c')) {
                    // fos_user_registration_check_email
                    if ('/registerok/check-email' === $pathinfo) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/registerok/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/registerok/confirm/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ('/registerok/confirmed' === $pathinfo) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ('/resetting/request' === $pathinfo) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ('/resetting/send-email' === $pathinfo) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ('/resetting/check-email' === $pathinfo) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'Bacloo\\UserBundle\\Controller\\ResettingController::resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        if (0 === strpos($pathinfo, '/p')) {
            // fos_user_change_password
            if ('/profile/change-password' === $pathinfo) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_change_password;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
            }
            not_fos_user_change_password:

            if (0 === strpos($pathinfo, '/payment')) {
                if (0 === strpos($pathinfo, '/payment/capture')) {
                    // payum_capture_do_session
                    if ('/payment/capture/session-token' === $pathinfo) {
                        return array (  '_controller' => 'Payum\\Bundle\\PayumBundle\\Controller\\CaptureController::doSessionTokenAction',  '_route' => 'payum_capture_do_session',);
                    }

                    // payum_capture_do
                    if (preg_match('#^/payment/capture/(?P<payum_token>[^/]++)$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'payum_capture_do')), array (  '_controller' => 'Payum\\Bundle\\PayumBundle\\Controller\\CaptureController::doAction',));
                    }

                }

                // payum_authorize_do
                if (0 === strpos($pathinfo, '/payment/authorize') && preg_match('#^/payment/authorize/(?P<payum_token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'payum_authorize_do')), array (  '_controller' => 'Payum\\Bundle\\PayumBundle\\Controller\\AuthorizeController::doAction',));
                }

                if (0 === strpos($pathinfo, '/payment/notify')) {
                    // payum_notify_do_unsafe
                    if (0 === strpos($pathinfo, '/payment/notify/unsafe') && preg_match('#^/payment/notify/unsafe/(?P<gateway>[^/]++)$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'payum_notify_do_unsafe')), array (  '_controller' => 'Payum\\Bundle\\PayumBundle\\Controller\\NotifyController::doUnsafeAction',));
                    }

                    // payum_notify_do
                    if (preg_match('#^/payment/notify/(?P<payum_token>[^/]++)$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'payum_notify_do')), array (  '_controller' => 'Payum\\Bundle\\PayumBundle\\Controller\\NotifyController::doAction',));
                    }

                }

            }

        }

        if (0 === strpos($pathinfo, '/import')) {
            // avro_csv_import_upload
            if (0 === strpos($pathinfo, '/import/upload') && preg_match('#^/import/upload/(?P<alias>[^/]++)(?:/(?P<id>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'avro_csv_import_upload')), array (  '_controller' => 'Avro\\CsvBundle\\Controller\\ImportController::uploadAction',  'id' => 0,));
            }

            // avro_csv_import_mapping
            if (0 === strpos($pathinfo, '/import/mapping') && preg_match('#^/import/mapping/(?P<alias>[^/]++)(?:/(?P<id>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'avro_csv_import_mapping')), array (  '_controller' => 'Avro\\CsvBundle\\Controller\\ImportController::mappingAction',  'id' => 0,));
            }

            // avro_csv_import_process
            if (0 === strpos($pathinfo, '/import/process') && preg_match('#^/import/process/(?P<alias>[^/]++)(?:/(?P<id>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'avro_csv_import_process')), array (  '_controller' => 'Avro\\CsvBundle\\Controller\\ImportController::processAction',  'id' => 0,));
            }

        }

        // avro_csv_export_export
        if (0 === strpos($pathinfo, '/export') && preg_match('#^/export/(?P<alias>[^/]++)(?:/(?P<user>[^/]++)(?:/(?P<dstart>[^/]++)(?:/(?P<dend>[^/]++)(?:/(?P<id>[^/]++))?)?)?)?$#sD', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'avro_csv_export_export')), array (  '_controller' => 'Avro\\CsvBundle\\Controller\\ExportController::exportAction',  'user' => 0,  'dstart' => 0,  'dend' => 0,  'id' => 0,));
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
