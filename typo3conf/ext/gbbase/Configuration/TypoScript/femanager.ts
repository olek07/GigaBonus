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

                _enable.client = 0

                email.uniqueInDb = 1
                // captcha.captcha = 1
                password < plugin.tx_femanager.settings.new.validation.password

                zip {
                    min = 5
                    max = 5
                    mustInclude = number
                }

                cityId {
                    mustInclude = number
                    required = 1
                }

                dateOfBirth {
                    date = 1
                    required = 1
                }

                language {
                    required = 1
                    inList = ua,ru
                }
            }
        }

        changemobilenumber {
            validation {
                # Enable clientside Formvalidation (JavaScript)
                _enable.client = 1

                # Enable serverside Formvalidation (PHP)
                _enable.server = 1

                // captcha.captcha = 1
                telephone {
                    min = 6
                    intOnly = 1
                    uniqueInDb = 1
                }
            }   
        }

        restorepassword {
            validation {
                _enable.client = 0
                _enable.server = 1
                // captcha.captcha = 1
                password < plugin.tx_femanager.settings.new.validation.password

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

Validation = PAGE
Validation {

    typeNum = 999

	config {
	    disableAllHeaderCode = 1
	    xhtml_cleaning = none
	    admPanel = 0
	    metaCharset = utf-8
	    additionalHeaders {
                10 {
                    header = Content-Type:application/json;charset=utf-8                        
                }
            }
	    disablePrefixComment = 1
	    debug = 0
            no_cache = 1
	}

    10 = USER_INT
    10 {
            userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
            extensionName = Gbfemanager
            pluginName = Pi2
            vendorName = Gigabonus
            controller = Validation
            action = validate
            switchableControllerActions {
                    Validation {
                            1 = validate
                    }
            }
            #view < plugin.tx_maramap.view
            #persistence < plugin.tx_maramap.persistence
            #settings < plugin.tx_maramap.settings
    }
}
