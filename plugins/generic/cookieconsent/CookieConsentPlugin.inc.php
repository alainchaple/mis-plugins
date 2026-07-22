<?php
/**
 * CookieConsent plugin for OJS 3.5
 *
 * Muestra un banner de aceptación de cookies usando cookieconsent (CDN).
 */

import('lib.pkp.classes.plugins.GenericPlugin');
import('lib.pkp.classes.core.JSONMessage');
use PKP\core\HookRegistry; // (si tu OJS no usa namespacing, esto no rompe)

class CookieConsentPlugin extends GenericPlugin {
    /**
     * Registrar plugin y hook para el footer cuando está habilitado.
     */
    public function register($category, $path) {
        if (!parent::register($category, $path)) return false;

        if ($this->getEnabled()) {
            HookRegistry::register('Templates::Common::Footer::PageFooter', array($this, 'appendCookieBanner'));
        }
        return true;
    }

    public function getDisplayName() {
        return __('plugins.generic.cookieconsent.displayName');
    }

    public function getDescription() {
        return __('plugins.generic.cookieconsent.description');
    }

    /**
     * Añade los assets JS/CSS al footer (hook callback).
     *
     * $args[0] = TemplateManager
     * $args[1] = &output (string)
     */
    public function appendCookieBanner($hookName, $args) {
        $templateMgr = $args[0];
        $output =& $args[1];

        // Contexto: sitio (0). Puedes cambiar para contextos de revista si lo adaptas.
        $contextId = 0;

        $message = $this->getSetting($contextId, 'message');
        if (empty($message)) {
            $message = 'Este sitio utiliza cookies para mejorar su experiencia.';
        }
        $policyUrl = $this->getSetting($contextId, 'policyUrl');
        if (empty($policyUrl)) {
            $policyUrl = '/about/cookies';
        }
        $position = $this->getSetting($contextId, 'position') ?: 'bottom-right';
        $theme = $this->getSetting($contextId, 'theme') ?: 'classic';
        $palettePopupBg = $this->getSetting($contextId, 'palettePopupBg') ?: '#000';
        $paletteButtonBg = $this->getSetting($contextId, 'paletteButtonBg') ?: '#f1d600';
        $dismissText = $this->getSetting($contextId, 'dismissText') ?: 'Aceptar';
        $linkText = $this->getSetting($contextId, 'linkText') ?: 'Leer más';

        // Construir JS seguro usando json_encode para escapar
        $js = '\n<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />\n<script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"></script>\n<script>\nwindow.addEventListener("load", function(){\n  try {\n    window.cookieconsent.initialise({\n      palette: {\n        popup: { background: ' . json_encode($palettePopupBg) . ' },\n        button: { background: ' . json_encode($paletteButtonBg) . ' }\n      },\n      theme: ' . json_encode($theme) . ',\n      position: ' . json_encode($position) . ',\n      content: {\n        message: ' . json_encode($message) . ',\n        dismiss: ' . json_encode($dismissText) . ',\n        link: ' . json_encode($linkText) . ',\n        href: ' . json_encode($policyUrl) . '\n      }\n    });\n  } catch (e) {\n    console && console.warn && console.warn("CookieConsent init error", e);\n  }\n});\n</script>\n';

        // Añadir al final del footer
        $output .= $js;
        // Permitimos que otros handlers sigan ejecutándose
        return false;
    }

    /**
     * Añadir un verbo de gestión para configuración en el UI de plugins.
     */
    public function getManagementVerbs() {
        $verbs = parent::getManagementVerbs();
        if ($this->getEnabled()) {
            $verbs[] = array('settings', __('plugins.generic.cookieconsent.settings'));
        }
        return $verbs;
    }

    /**
     * Maneja la acción "settings" (abre un modal con el formulario y guarda).
     */
    public function manage($verb, $args, $request) {
        if ($verb === 'settings') {
            $templateMgr = TemplateManager::getManager($request);

            // Guardar si viene el submit
            if ($request->getUserVar('save')) {
                $contextId = 0;
                $message = $request->getUserVar('message');
                $policyUrl = $request->getUserVar('policyUrl');
                $position = $request->getUserVar('position');
                $theme = $request->getUserVar('theme');
                $palettePopupBg = $request->getUserVar('palettePopupBg');
                $paletteButtonBg = $request->getUserVar('paletteButtonBg');
                $dismissText = $request->getUserVar('dismissText');
                $linkText = $request->getUserVar('linkText');

                $this->updateSetting($contextId, 'message', $message, 'string');
                $this->updateSetting($contextId, 'policyUrl', $policyUrl, 'string');
                $this->updateSetting($contextId, 'position', $position, 'string');
                $this->updateSetting($contextId, 'theme', $theme, 'string');
                $this->updateSetting($contextId, 'palettePopupBg', $palettePopupBg, 'string');
                $this->updateSetting($contextId, 'paletteButtonBg', $paletteButtonBg, 'string');
                $this->updateSetting($contextId, 'dismissText', $dismissText, 'string');
                $this->updateSetting($contextId, 'linkText', $linkText, 'string');

                // Responder con éxito (JSONMessage para modal)
                return new JSONMessage(true, __('plugins.generic.cookieconsent.settingsSaved'));
            }

            // Asignar valores actuales al template
            $contextId = 0;
            $templateMgr->assign('message', $this->getSetting($contextId, 'message'));
            $templateMgr->assign('policyUrl', $this->getSetting($contextId, 'policyUrl'));
            $templateMgr->assign('position', $this->getSetting($contextId, 'position') ?: 'bottom-right');
            $templateMgr->assign('theme', $this->getSetting($contextId, 'theme') ?: 'classic');
            $templateMgr->assign('palettePopupBg', $this->getSetting($contextId, 'palettePopupBg') ?: '#000');
            $templateMgr->assign('paletteButtonBg', $this->getSetting($contextId, 'paletteButtonBg') ?: '#f1d600');
            $templateMgr->assign('dismissText', $this->getSetting($contextId, 'dismissText') ?: 'Aceptar');
            $templateMgr->assign('linkText', $this->getSetting($contextId, 'linkText') ?: 'Leer más');

            return new JSONMessage(true, $templateMgr->fetch($this->getTemplatePath() . 'settings.tpl'));
        }

        return parent::manage($verb, $args, $request);
    }
}
