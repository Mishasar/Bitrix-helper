<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
?>
<section class="section">
    <div class="container">
        <div class="content-half">
            <div class="content-half__box">
                <div class="form__wrap">
                    <form class="form js-form validator" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                        <?if($arResult["BACKURL"] <> ''):?>
                            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                        <?endif?>
                        <input type="hidden" name="AUTH_FORM" value="Y">
                        <input type="hidden" name="TYPE" value="SEND_PWD">
                        <?
                        if(!empty($arParams["~AUTH_RESULT"])):
                            $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
                            ?>
                            <div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
                        <?endif?>
                        <h4 class="h4 form__title">Введите свой Email</h4>
                        <label class="field">
                            <input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
                            <input type="hidden" name="USER_EMAIL" />
                        </label>
                        <?if ($arResult["USE_CAPTCHA"]):?>
                            <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                            <div class="bx-authform-formgroup-container">
                                <div class="bx-authform-label-container"><?echo GetMessage("system_auth_captcha")?></div>
                                <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
                                <div class="bx-authform-input-container">
                                    <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                                </div>
                            </div>
                        <?endif?>
                        <div class="form__bottom">
                            <input type="submit" class="btn btn-yellow form__button" name="send_account_info" value="Восстановить" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
    document.bform.USER_LOGIN.focus();
</script>