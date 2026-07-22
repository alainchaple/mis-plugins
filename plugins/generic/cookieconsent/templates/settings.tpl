{* Formulario simple para la UI de administración de plugins (modal) *}
<form id="cookieconsent-settings-form" method="post" action="{$pluginUrl|escape}">
  <input type="hidden" name="save" value="1" />
  <fieldset>
    <label for="message">Mensaje (banner)</label><br/>
    <textarea id="message" name="message" rows="3" style="width:100%">{if $message}{$message|escape}{/if}</textarea>
  </fieldset>

  <fieldset>
    <label for="policyUrl">URL de la política de cookies</label><br/>
    <input id="policyUrl" name="policyUrl" type="text" style="width:100%" value="{if $policyUrl}{$policyUrl|escape}{/if}" />
  </fieldset>

  <fieldset>
    <label for="position">Posición</label><br/>
    <select id="position" name="position">
      <option value="bottom" {if $position == 'bottom'}selected{/if}>Abajo (centro)</option>
      <option value="bottom-left" {if $position == 'bottom-left'}selected{/if}>Abajo izquierda</option>
      <option value="bottom-right" {if $position == 'bottom-right'}selected{/if}>Abajo derecha</option>
      <option value="top" {if $position == 'top'}selected{/if}>Arriba (centro)</option>
      <option value="top-left" {if $position == 'top-left'}selected{/if}>Arriba izquierda</option>
      <option value="top-right" {if $position == 'top-right'}selected{/if}>Arriba derecha</option>
    </select>
  </fieldset>

  <fieldset>
    <label for="theme">Tema</label><br/>
    <select id="theme" name="theme">
      <option value="classic" {if $theme == 'classic'}selected{/if}>Classic</option>
      <option value="edgeless" {if $theme == 'edgeless'}selected{/if}>Edgeless</option>
      <option value="block" {if $theme == 'block'}selected{/if}>Block</option>
    </select>
  </fieldset>

  <fieldset>
    <label>Colores</label><br/>
    <label for="palettePopupBg">Fondo popup</label>
    <input id="palettePopupBg" name="palettePopupBg" type="text" value="{if $palettePopupBg}{$palettePopupBg|escape}{/if}" />
    <br/>
    <label for="paletteButtonBg">Fondo botón</label>
    <input id="paletteButtonBg" name="paletteButtonBg" type="text" value="{if $paletteButtonBg}{$paletteButtonBg|escape}{/if}" />
  </fieldset>

  <fieldset>
    <label for="dismissText">Texto botón aceptar</label>
    <input id="dismissText" name="dismissText" type="text" value="{if $dismissText}{$dismissText|escape}{/if}" />
    <br/>
    <label for="linkText">Texto enlace</label>
    <input id="linkText" name="linkText" type="text" value="{if $linkText}{$linkText|escape}{/if}" />
  </fieldset>

  <div style="margin-top:0.8em">
    <button type="submit" class="pkpButton primary">Guardar</button>
    <button type="button" class="pkpButton" onclick="$('.pkpModal').dialog('close');">Cancelar</button>
  </div>
</form>
