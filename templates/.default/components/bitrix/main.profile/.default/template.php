<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="cabinet-box">
    <div class="cabinet-head">
        <h3 class="h3 cabinet-head__title">Личные данные</h3>
        <a class="cabinet-logout" href="/?logout=yes">Выйти</a>
    </div>
    <div class="cabinet-body">
        <p class="form__text">
        <? ShowError($arResult["strProfileError"]); ?>
        <?if ($arResult['DATA_SAVED'] == 'Y'): ?>
            Изменения сохранены
        <?endif;?>
        </p>
        <form method="post" class="cabinet-form js-form validator" action="<?= $arResult["FORM_TARGET"] ?>">
            <?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
            <input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>"/>

            <div class="cabinet-form__field">
                <label class="field">
                    <p>Название организации / Ф.И.О.</p>
                    <input type="text" name="NAME" maxlength="50" value="<?= $arResult["arUser"]["NAME"] ?>"
                           data-validator-require="true"/>
                </label>
            </div>
            <div class="cabinet-form__field">
                <label class="field">
                    <p>ИНН / Паспортные данные</p>
                    <input type="text" name="PERSONAL_NOTES" value="<?= $arResult["arUser"]["PERSONAL_NOTES"] ?>"
                           placeholder="" data-validator-require="true">
                </label>
            </div>
            <div class="cabinet-form__field">
                <label class="field">
                    <p>Город</p>
                    <input type="text" name="PERSONAL_CITY" value="<?= $arResult["arUser"]["PERSONAL_CITY"] ?>"
                           placeholder="" data-validator-require="true">
                </label>
            </div>
            <div class="cabinet-form__field">
                <label class="field">
                    <p>Адрес</p>
                    <input type="text" name="PERSONAL_STREET" value="<?= $arResult["arUser"]["PERSONAL_STREET"] ?>"
                           placeholder="" data-validator-require="true">
                </label>
            </div>
            <div class="cabinet-form__field">
                <label class="field">
                    <p>Электронная почта</p>
                    <input type="text" name="EMAIL" value="<?= $arResult["arUser"]["EMAIL"] ?>" placeholder=""
                           data-validator-require="true" data-validator-type="email">
                </label>
            </div>
            <div class="cabinet-form__field">
                <label class="field">
                    <p>Номер телефона</p>
                    <input class="js-input-mask" type="text" name="PERSONAL_PHONE"
                           value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>" placeholder=""
                           data-validator-require="true" data-validator-type="phone">
                </label>
            </div>
            <div class="cabinet-form__button">
                <input class="btn btn-yellow" type="submit" name="save" value="Сохранить">
            </div>
        </form>
    </div>
</div>