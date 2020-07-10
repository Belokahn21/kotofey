<div class="modal fade authModal" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="auth-form" method="post" action="/">
                <div class="modal-header">
                    <div class="div"><h5 class="modal-title" id="signupModalLabel">Регистрация</h5>
                        <ul class="auth-modal-toggle">
                            <li class="auth-modal-toggle__item active"><a class="auth-modal-toggle__link"
                                                                          href="javascript:void(0);" data-toggle="modal"
                                                                          data-target="#signupModal">Регистрация</a>
                            </li>
                            <li class="auth-modal-toggle__item"><a class="auth-modal-toggle__link"
                                                                   href="javascript:void(0);" data-toggle="modal"
                                                                   data-target="#signinModal">Вход</a></li>
                        </ul>
                    </div>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="auth-form__item"><label class="auth-form__label" for="auth-form-fio">ФИО</label><input
                            class="auth-form__input" id="auth-form-fio" type="text" placeholder="Ваша фамилия">
                    </div>
                    <div class="auth-form__group-row">
                        <div class="auth-form__item"><label class="auth-form__label" for="auth-form-phone">Контактный
                                телефон</label><input class="auth-form__input js-mask-ru" id="auth-form-phone"
                                                      type="text"
                                                      placeholder="+7 (___) ___ __-__"></div>
                        <div class="auth-form__item"><label class="auth-form__label" for="auth-form-email">Адрес вашей
                                электронной почты</label><input class="auth-form__input" id="auth-form-email"
                                                                type="text"
                                                                placeholder="Адрес вашей электронной почты"></div>
                    </div>
                </div>
                <div class="auth-fill">
                    <div class="auth-form__group-row">
                        <div class="auth-form__item"><label class="auth-form__label" for="auth-form-password">Придумайте
                                пароль</label><input class="auth-form__input" id="auth-form-password" type="password"
                                                     placeholder="Пароль"></div>
                        <div class="auth-form__item"><label class="auth-form__label" for="auth-form-password-confirm">Повторить
                                пароль</label><input class="auth-form__input" id="auth-form-password-confirm"
                                                     type="password" placeholder="Пароль"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="auth-form__button" type="submit">Регистрация</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- Modal-->
<div class="authModal modal fade" id="signinModal" tabindex="-1" role="dialog" aria-labelledby="signinModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="auth-form">
                <div class="modal-header">
                    <div class="div"><h5 class="modal-title" id="signinModalLabel">Войти в личный кабинет</h5>
                        <ul class="auth-modal-toggle">
                            <li class="auth-modal-toggle__item"><a class="auth-modal-toggle__link"
                                                                   href="javascript:void(0);" data-toggle="modal"
                                                                   data-target="#signupModal">Регистрация</a></li>
                            <li class="auth-modal-toggle__item active"><a class="auth-modal-toggle__link"
                                                                          href="javascript:void(0);" data-toggle="modal"
                                                                          data-target="#signinModal">Вход</a></li>
                        </ul>
                    </div>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="auth-form__item"><label class="auth-form__label" for="auth-form-email">Адрес вашей электронной почты</label><input class="auth-form__input" id="auth-form-email" type="text" placeholder="Адрес вашей электронной почты"></div>
                    <div class="auth-form__item"><label class="auth-form__label" for="auth-form-password">Пароль</label>
                        <input class="auth-form__input" id="auth-form-password" type="password" placeholder="Пароль">
                    </div>
                    <div class="modal-footer">
                        <button class="auth-form__button" type="button">Авторизоваться</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
