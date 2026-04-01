<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arResult
 */

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?= $arResult["FORM_NOTE"] ?? '' ?>
<?if ($arResult["isFormNote"] != "Y")
{
?>
<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<?
if ($arResult["isFormTitle"])
{
?>
	<div class="contact-form">
    <div class="contact-form__head">
		<div class="contact-form__head-title"><?=$arResult["FORM_TITLE"]?></div>
<?
} //endif ;

	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300" <?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" alt=""/></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

			<div class="contact-form__head-text"><?=$arResult["FORM_DESCRIPTION"]?></div>
</div>


	<?
} // endif
	?>
<?$formHeader = str_replace('<form', '<form class="contact-form__form"', $arResult["FORM_HEADER"]);?>
<?=$formHeader ?>

<div class="contact-form__form-inputs">

	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
	?>
		<?if (isset($arResult["FORM_ERRORS"][$FIELD_SID])):?>
			<span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
		<?endif;?>
		<?if (substr($arQuestion["HTML_CODE"], 0, 9) != '<textarea'){
			$input = str_replace('<input', '<input class="input__input"', $arQuestion["HTML_CODE"]);?>
			<div class="input contact-form__input">
			<label class="input__label"><div class="input__label-text"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
			<div class="input__input"><?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?></div>
			<?=$input?></div>
			<div class="input__notification">dsa</div></label></div>
		<?}
		else{
			$captionMessage = $arQuestion["CAPTION"];
			$message = str_replace('<textarea', '<textarea class="input__input"', $arQuestion["HTML_CODE"]);
		}?>
			
	
	<?
		}
	} //endwhile
	?>
	</div>
		<div class="contact-form__form-message">
			<div class="input"><label class="input__label">
				<div class="input__label-text"><?=$captionMessage?></div>
				<?=$message?>
		<div class="input__notification"></div>
		</label></div>
</div>
<?
if($arResult["isUseCaptcha"] == "Y")
{
?>

			<b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></th>

			&nbsp;
			<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" alt=""/>


			<?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
			<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />

<?
} // isUseCaptcha
?>
<div class="contact-form__bottom">
			<div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
                ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
                данных&raquo;.
            </div>
				<button <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> class="form-button contact-form__bottom-button" data-success="Отправлено" data-error="Ошибка отправки" type="submit" name="web_form_submit"><div class="form-button__title"><?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?></div>
            </button>

</div>
<?=$arResult["FORM_FOOTER"]?>

<?
} //endif (isFormNote)