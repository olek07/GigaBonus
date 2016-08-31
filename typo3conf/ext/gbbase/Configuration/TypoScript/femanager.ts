plugin.tx_femanager {
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
            }
        }
    }

    _LOCAL_LANG {
        # Default Language
        ru.tx_femanager_domain_model_user.dateFormat = m.d.Y
        ru.tx_femanager_domain_model_user.dateOfBirth.placeholder = m.d.Y

        # For DE
        ua.tx_femanager_domain_model_user.dateFormat = m.d.Y
        ua.tx_femanager_domain_model_user.dateOfBirth.placeholder = m.d.Y
    }

}