<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

//CJSCore::Init();
?>

<div id="ajax-auth-form-wrapper">
    <div class="js-form-auth-errors">
        <?
        if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']) {
            ShowMessage($arResult['ERROR_MESSAGE']);
        }
        ?>
    </div>


    <form class="modal__form-auth validator js-form-auth"
          name="system_auth_form<?= $arResult["RND"] ?>"
          method="post"
          action="/service/auth/">
        <? if ($arResult["BACKURL"] <> ''): ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
        <? endif ?>
        <? foreach ($arResult["POST"] as $key => $value): ?>
            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
        <? endforeach ?>



        <label class="field">
            <p>Пароль</p>
            <input type="text" name="USER_LOGIN" maxlength="50" value="" size="17"/>
            <script>
                BX.ready(function () {
                    var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
                    if (loginCookie) {
                        var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
                        var loginInput = form.elements["USER_LOGIN"];
                        loginInput.value = loginCookie;
                    }
                });
            </script>
        </label>
        <label class="field">
            <p>Электронная почта</p>
            <input type="password" name="USER_PASSWORD" maxlength="50" size="17" autocomplete="off"/>
        </label>

        <? if ($arResult["CAPTCHA_CODE"]): ?>
            <tr>
                <td colspan="2">
                    <? echo GetMessage("AUTH_CAPTCHA_PROMT") ?>:<br/>
                    <input type="hidden" name="captcha_sid" value="<? echo $arResult["CAPTCHA_CODE"] ?>"/>
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<? echo $arResult["CAPTCHA_CODE"] ?>" width="180"
                         height="40" alt="CAPTCHA"/><br/><br/>
                    <input type="text" name="captcha_word" maxlength="50" value=""/></td>
            </tr>
        <? endif ?>

        <input class="btn btn-yellow modal__button-auth" type="submit" name="Login" value="Войти"/>
        <div class="modal__link-wrap">
            <a class="modal__link modal__link-forgot" href="<?= $arResult["AUTH_FORGOT_PASSWORD_URL"] ?>">Забыли
                пароль?</a>
        </div>

    </form>
</div>
