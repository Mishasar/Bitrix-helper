</main>
<footer class="footer">
    <div class="footer__top">
        <div class="container">
            <div class="footer__top-inner">
                <div class="footer__top-left">
                    <a class="logo icon-logo" href="/"></a>
                </div>
                <div class="footer__top-middle">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "footer", [
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "N",
                    ],
                        false
                    );?>
                </div>
                <div class="footer__top-right">
                    <div class="social">
                        <a class="social__item icon-vk" href="<?= Letsrock\Lib\Models\Property::getText('SOC_VK') ?>" target="_blank"></a>
                        <a class="social__item icon-youtube" href="<?= Letsrock\Lib\Models\Property::getText('SOC_YOUTUBE') ?>" target="_blank"></a>
                        <a class="social__item icon-instagram" href="<?= Letsrock\Lib\Models\Property::getText('SOC_INST') ?>" target="_blank"></a>
                    </div>
                    <div class="link-with-desc phone"><a class="link" href="tel:><?= Letsrock\Lib\Models\Property::getText('MAIN_PHONE') ?>"><?= Letsrock\Lib\Models\Property::getText('MAIN_PHONE') ?></a><span class="desc">обратный звонок</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottom-inner">
                <div class="footer__copyright">© Диодтрейд</div><a class="footer__authors" href="https://letsrock.pro/" target="_blank"><span>Разработка сайта</span>
                    <div class="footer__authors-logo"><svg width="93" height="20" viewBox="0 0 93 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g class="footer__authors-hand">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.9457 15.8487C19.9555 12.7038 20.9172 10.6178 21.9431 7.59935C22.3118 6.55633 22.6163 5.97161 22.5202 5.37109C22.3438 4.40709 21.6866 4.13843 21.0455 4.9602C20.9493 5.11824 20.8371 5.24466 20.757 5.38689C20.3723 6.01902 20.0356 6.68276 19.5868 7.45712C18.2404 9.74859 17.2306 12.767 16.5253 13.7942C15.6116 15.2165 14.3453 14.9479 13.9606 13.5098C12.9348 14.2525 11.7005 13.4624 11.7486 12.1665C11.7807 11.0129 12.0852 9.54315 12.2455 8.35791C12.4539 6.90401 12.8706 3.20604 12.8386 1.21483C12.8065 0.961978 12.7905 0.788143 12.7424 0.598503C12.502 -0.081037 11.7967 -0.160053 11.2036 0.250832C10.867 0.472077 10.5785 0.961979 10.4342 1.59411C10.1778 2.5107 10.0976 3.5063 9.96938 4.50191C9.88924 5.16565 8.78323 11.0919 8.52677 11.566C7.72531 13.1779 4.90419 10.4755 2.80439 9.85922C0.480169 9.22709 -0.962448 10.4123 0.752664 11.4237C1.89073 12.1191 5.68962 15.0427 6.63534 16.0383C6.87577 16.2753 6.92386 16.2911 7.14827 16.4966C7.48488 16.8285 7.69325 17.1287 8.06192 17.4448C10.1778 19.357 13.9125 20.2578 16.7337 18.8197C17.3107 18.5194 17.4389 18.393 17.8397 17.9821C18.5129 17.3026 18.6571 16.702 18.9457 15.8487Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0726 12.3717C14.5855 11.2813 14.9542 9.66939 15.0824 8.67378C15.2106 7.70978 14.9221 7.2989 13.8963 7.14087C13.6077 7.09346 13.3192 7.10926 13.0628 7.3147C12.6781 7.59916 12.7261 8.10487 12.5658 8.94244C12.3094 10.6808 11.7644 12.5456 12.5178 13.1461C13.3352 13.794 13.8001 13.0039 14.0726 12.3717Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2525 13.3834C17.086 12.0244 18.1118 9.65392 17.5989 8.86375C17.1661 8.23162 15.9479 7.89976 15.5792 8.91116C15.2907 9.70133 15.0343 10.9339 14.8259 11.6135C14.5854 12.3562 14.2328 13.3518 14.5373 13.8575C15.0823 14.7899 15.8838 13.9524 16.2525 13.3834Z" fill="white"/>
                            </g>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M59.0503 11.3448L59.9799 6.90411C61.3264 6.85671 63.5544 6.52484 62.5766 9.43264C61.8714 11.5029 60.541 11.3764 59.0503 11.3448ZM54.2095 19.5151H57.271L58.5373 13.7153C60.2204 13.5099 60.2685 14.6635 60.5249 15.912L61.1981 19.5151H64.3078L63.5544 15.833C63.3781 14.9322 62.9613 14.2052 62.6247 13.8417C62.4164 13.6363 62.24 13.5415 61.9996 13.3518C62.4965 13.0516 62.8812 12.9252 63.2659 12.6881C63.891 12.3246 64.4841 11.8189 65.0772 10.7917C65.7985 9.54326 66.1672 7.63107 65.4459 6.22457C64.7245 4.77067 63.5224 4.48622 61.4065 4.48622C59.467 4.48622 57.5435 4.45461 55.604 4.48622L55.1392 6.85671H56.7901L54.2095 19.5151Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M82.9658 19.5151H85.6908L86.6525 15.3114C87.8226 15.2166 87.9188 15.8171 88.1753 17.0497L88.6722 19.5309L91.4933 19.4992L91.1086 17.6029C90.6918 15.8171 90.8521 15.4852 89.7942 14.3632L93 9.76444L90.0827 9.79605C89.3614 10.76 88.7042 11.9611 88.0631 12.9567H87.1494C87.1013 12.1191 88.6561 6.1613 88.8806 4.50195H84.3764L83.9436 6.87244H85.5786C85.3221 8.89526 82.9979 18.4878 82.9658 19.5151Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M31.5285 15.6116H28.9959L28.6593 17.113H26.6076L29.2684 4.50195L24.3795 4.56517L23.8185 6.88825H25.5977L22.8728 19.5151L30.695 19.4834" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M67.9946 16.528C67.8183 15.9117 67.9145 15.2322 68.1549 14.3314C68.4114 13.3674 69.1327 11.7554 70.3509 12.1663C71.3126 12.4508 71.3607 15.248 70.3509 16.7019C69.5815 17.8555 68.3954 18.0293 67.9946 16.528ZM67.1451 19.7519C67.3855 19.8467 67.658 19.9099 68.0267 19.9573C70.5432 20.2102 71.8095 19.2936 72.5789 18.298C73.2842 17.3972 73.5086 16.7177 73.7971 15.6272C74.2139 14.1417 74.4383 12.435 73.4926 11.1549C72.4828 9.79585 70.431 9.36916 68.4915 10.1593C66.9688 10.7914 65.8467 12.0715 65.2857 13.8099C64.9972 14.7107 64.8209 15.7537 64.917 16.7493C65.0453 18.1716 65.7506 19.2304 67.1451 19.7519Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M35.3594 14.5846C35.5196 13.5416 36.0326 12.3563 36.9943 12.1667C37.7637 12.0086 38.0683 12.5617 37.908 13.2097C37.8439 13.4941 37.7317 13.7786 37.4752 14.0315C36.9943 14.4897 36.241 14.6162 35.3594 14.5846ZM33.0993 18.9621C34.7342 20.9059 37.94 19.5784 39.3666 19.0885L38.9018 17.0499C37.6355 17.4766 35.7761 18.409 35.2792 16.5126C37.379 16.6864 39.2063 16.0227 40.2482 14.2369C42.8449 9.74881 36.3852 8.13688 33.6282 11.74C32.6665 12.9884 32.1856 14.3159 32.1535 16.0543C32.1535 16.0385 32.0093 17.6504 33.0993 18.9621Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M47.3975 13.9209C47.8142 15.5329 50.1865 15.7541 50.4751 16.4969C51.02 17.8559 48.4874 18.0298 47.0288 16.8761L46.051 18.9148C46.8044 19.863 49.1286 20.1158 50.6033 19.8155C52.3825 19.4521 53.3923 18.0298 53.4725 16.2914C53.5206 15.5013 53.3443 15.0904 52.639 14.4582C52.0138 13.9209 51.2925 13.7629 50.7155 13.3836C50.4109 13.1782 50.2987 13.1308 50.3308 12.7515C50.3789 12.0561 50.9559 12.0878 51.8055 12.1194L51.6291 13.1624L53.6168 13.1308L54.9151 9.1958L52.4787 9.2274L52.3505 9.81212C51.1322 9.73311 49.7217 9.7015 48.7599 10.4442C48.7599 10.46 46.8845 11.9613 47.3975 13.9209Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M75.9288 19.1832C76.1853 19.4202 76.57 19.6414 77.147 19.7995C77.7882 20.0049 78.5416 20.0365 79.2629 19.9259C79.7277 19.8785 80.0643 19.7679 80.3689 19.6889C80.7536 19.594 81.0742 19.4518 81.4589 19.3096C81.6191 19.2306 81.7955 19.1832 81.9718 19.0725L81.5069 17.0497C80.6253 17.3342 77.4676 18.9145 77.8042 15.3114C78.0126 13.2411 78.6538 11.8662 80.994 12.1507L80.8177 13.1463L82.7893 13.1147L84.1037 9.17969H81.6993L81.523 9.87503C78.7499 9.59057 77.2592 10.3649 76.0891 11.9137C75.1274 13.1621 74.6946 14.9479 74.8228 16.7653C74.8869 17.6818 75.1915 18.5668 75.9288 19.1832Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M41.0977 19.5154H43.7745L45.3454 12.0879L46.8521 12.1195L47.6055 9.81227H45.8743L46.4674 6.88867H44.0791L43.1975 9.81227H41.7709L41.306 12.0879H42.5242L41.0977 19.5154Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M47.5254 8.43697H49.4649L50.8594 4.50195H48.3589L47.5254 8.43697Z" fill="white"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</footer>
<div class="preloader-loader">
    <div class="preloader-inner preloader-one"></div>
    <div class="preloader-inner preloader-two"></div>
    <div class="preloader-inner preloader-three"></div>
</div>
<div class="preloader-wrap"></div>
<div class="modal-list">
    <div class="modal modal__auth js-modal" data-modal-type="auth">
        <div class="modal__inner">
            <div class="close modal__close js-modal-close"></div>
            <div class="modal__head">
                <div class="modal__title">Войти</div>
            </div>
            <div class="modal__content">
                <form class="modal__form-auth validator js-form-auth" action="/ajax-virtual/forms/auth/" method="post">
                    <div class="modal__form-error form__text js-form-auth-errors"></div>
                    <label class="field">
                        <p>Электронная почта</p>
                        <input type="text" name="email" value="" placeholder="" data-validator-require="true" data-validator-type="email">
                    </label>
                    <label class="field">
                        <p>Пароль</p>
                        <input type="password" name="password" value="" placeholder="" data-validator-require="true">
                    </label>
                    <button class="btn btn-yellow modal__button-auth" type="submit">Войти</button>
                    <div class="modal__link-wrap">
                        <a class="modal__link modal__link-forgot" href="/restore/">Забыли пароль?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal__auth js-modal js-modal-add2basket" data-modal-type="buy">
        <div class="modal__inner">
            <div class="close modal__close js-modal-close"></div>
            <div class="modal__head">
                <div class="modal__title">Выберите склад</div>
            </div>
            <div class="modal__content">
                <div class="catalog-detail__commerce js-inner">

                </div>
                <a class="btn btn-yellow modal__button-full" href="/cart/">Перейти к оформлению</a>
                <div class="modal__link-wrap"><a class="modal__link js-modal-close" href="javascript:void(0)">Продолжить покупки</a></div>
            </div>
        </div>
    </div>
    <div class="modal modal__auth js-modal" data-modal-type="buy-bonus">
        <div class="modal__inner">
            <div class="modal__head">
                <div class="modal__title">Спасибо</div>
            </div>
            <p class="modal__content modal__content_light">
                В ближайшее время с вами свяжется менеджер.
            </p>
        </div>
    </div>
</div>
</div>
</body>
</html>