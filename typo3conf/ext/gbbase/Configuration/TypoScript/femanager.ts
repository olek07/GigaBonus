plugin.tx_femanager {
    view.partialRootPaths.10 = EXT:gbfemanager/Resources/Private/Partials/
    view.templateRootPaths.10 = EXT:gbfemanager/Resources/Private/Templates/

    settings {
        new {
            validation {
                // to use email as login, because username is by default required 
                username.required = 0
                // captcha.captcha = 1
                email.uniqueInDb = 1
                password {
                    min = 6
                    mustInclude = number,letter
                }

                password_repeat {
                  required = 0

                }
            }
            // email.createUserConfirmation.sender = vinslave@mail.ru
        }
    
        edit {
            validation {
                email.uniqueInDb = 1
                // captcha.captcha = 1
                password < plugin.tx_femanager.settings.new.validation.password
            }
        }

        changemobilenumber {
            validation {
                // captcha.captcha = 1
            }   
        }

    }

    _LOCAL_LANG {
        # Default Language
        ru.tx_femanager_domain_model_user.dateFormat = d.m.Y
        ru.tx_femanager_domain_model_user.dateOfBirth.placeholder = d.m.Y

        # For DE
        ua.tx_femanager_domain_model_user.dateFormat = d.m.Y
        ua.tx_femanager_domain_model_user.dateOfBirth.placeholder = d.m.Y
    }

}