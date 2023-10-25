<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
================================================================================
View of the jQueryUI themes which can be set for your application.
File version: 1.4
Last update: 11/28/2019
-->
<script type="text/javascript">
    znetdk.useStyleSheet('<?php echo ZNETDK_ROOT_URI . \General::getFilledMessage(CFG_ZNETDK_CSS, "try_themes"); ?>');
</script>
<p id="zdk_try_themes_teaser"><?php echo LC_THEME_MESSAGE;?></p>
<?php
$themes = array('afterdark', 'afternoon', 'afterwork', 'aristo', 'asphalt', 'black-tie', 'blitzer', 'bluesky', 'bootstrap', 'casablanca', 'cruze',
    'cupertino', 'dark-hive', 'dot-luv', 'eggplant', 'excite-bike', 'flat-blue', 'flat-two', 'flick', 'glass-x', 'greensea', 'home', 'humanity', 'le-frog', 'midnight',
    'mint-choc', 'overcast', 'pepper-grinder', 'redmond', 'rocket', 'sam', 'smoothness', 'south-street', 'start', 'sunny', 'swanky-purse', 'trontastic',
    'ui-darkness', 'ui-lightness', 'vader', 'znetdk','z-bluegrey','z-cyan','z-funny','z-hot-sneaks','z-mono-airyblue','z-mono-aurorared','z-mono-bodacious',
    'z-mono-icedcoffe','z-mono-lilacgrey','z-mono-lushmedow','z-mono-riverside','z-mono-rosequarts','z-mono-serenity','z-mono-taupe','z-teal','z-w10');
foreach ($themes as $theme_name) {
    ?>
    <div class="theme-thumbnail">
        <img class="theme-image" src="<?php echo ZNETDK_ROOT_URI . 'resources/images/themes/' . $theme_name; ?>.png" alt="<?php echo $theme_name; ?>"/>
        <div class="theme-name"><?php echo $theme_name; ?></div>
    </div>
<?php }
?>
<script type="text/javascript">
    console.log('Try Themes...');
    $('div.theme-thumbnail > img.theme-image').click(function (event) {
        var themeName = $(this).siblings("div.theme-name").text();
        var themeLink = $('link[href*="theme.css"]');
        var newThemeURL = '<?php echo ZNETDK_ROOT_URI . CFG_THEME_PRIMEUI_DIR; ?>/' + themeName + '/theme.css';
        var znetdkThemes = ['asphalt','flat-blue','flat-two','greensea','znetdk','z-bluegrey','z-cyan','z-funny','z-hot-sneaks','z-mono-airyblue','z-mono-aurorared','z-mono-bodacious',
            'z-mono-icedcoffe','z-mono-lilacgrey','z-mono-lushmedow','z-mono-riverside','z-mono-rosequarts','z-mono-serenity','z-mono-taupe','z-teal','z-w10'];
        if (znetdkThemes.indexOf(themeName) >=0) {
            newThemeURL = '<?php echo ZNETDK_ROOT_URI . CFG_THEME_ZNETDK_DIR; ?>/' + themeName + '/theme.css';
        }
        event.preventDefault();
        $(this).parent('.theme-thumbnail').animate({
                opacity: 0.25
            }, 500, function () {
                themeLink.attr('href', newThemeURL);
                $('#zdk-office-menu').zdkofficemenu('refreshIconsColor');
            }
        );
    });
</script>
