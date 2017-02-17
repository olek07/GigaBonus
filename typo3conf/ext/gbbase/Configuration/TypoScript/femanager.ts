plugin.tx_femanager {
    view.layoutRootPaths.10 = EXT:gbfemanager/Resources/Private/Layouts/
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
                    mustInclude = number
                    required = 1
                }

                password_repeat {
                    sameAs = password
                    required = 1
                }
            }

            pageType = 104

            email {
                createUserConfirmation {
                    # Add Embed Images (separate each with comma) - can be used in mail with <img src="{embedImages.0}" /> and so on...
                    embedImage = COA
                    embedImage {
                        10 = IMG_RESOURCE
                        10 {
                            file = fileadmin/user_upload/peppa.jpg
                            file.maxW = 100
							file.maxH = 100
                        }

#						10 = IMG_RESOURCE
#						10 {
#							wrap = |,
#							file.import = uploads/pics/
#							file.import.field = image
#							file.import.listNum = 0
#							file.maxW = 120
#							file.maxH = 120
#						}

                        # 20 = TEXT
                        # 20.value = fileadmin/user_upload/peppa.jpg
                    }

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
                password_repeat < plugin.tx_femanager.settings.new.validation.password_repeat

                firstName {
                    min = 2
                    max = 20
#                    required = 1
                }

                middleName {
                    min = 2
                    max = 20
#                    required = 1
                }

                lastName {
                    min = 2
                    max = 20
#                    required = 1
                }

                zip {
                    min = 5
                    max = 5
                    intOnly = 1
#                    required = 1
                }

                cityId {
                    intOnly = 1
                    required = 1
                }

                dateOfBirth {
                    date = 1
#                    required = 1
                }

                language {
#                    required = 1
                    inList = 0,1
                }

                gender {
#                    required = 1
#                    inList = m,w,0
                }
            }

            misc.keepPasswordIfEmpty = 0

        }

        changemobilenumber {
            validation {
                # Enable clientside Formvalidation (JavaScript)
                _enable.client = 0

                # Enable serverside Formvalidation (PHP)
                _enable.server = 1

                // captcha.captcha = 1
                telephone {
                    min = 6
                    intOnly = 1
                    uniqueInDb = 1
                }
            }

            pageType = 109
        }

        restorepassword {
            validation {
                _enable.client = 0
                _enable.server = 1
                // captcha.captcha = 1
                password < plugin.tx_femanager.settings.new.validation.password

            }

            loginPageUid = {$pages.loginPageUid}
        }

    }

    _LOCAL_LANG {
        # Default Language
        ru.tx_femanager_domain_model_user.dateFormat = d.m.Y
        ru.tx_femanager_domain_model_user.dateOfBirth.placeholder = d.m.Y

        # For DE
        uk.tx_femanager_domain_model_user.dateFormat = d.m.Y
        uk.tx_femanager_domain_model_user.dateOfBirth.placeholder = d.m.Y
    }

}


page.includeJSFooter.femanagerValidation >
page.includeJSFooter.femanager >

### Change data of FE User
[globalVar = TSFE:id = {$pages.changeUserDataPageUid}, TSFE:type = 106]
    plugin.tx_femanager.settings.edit.pageType = 106
    plugin.tx_femanager.settings.edit.validation.gender.required = 1
    plugin.tx_femanager.settings.edit.validation.dateOfBirth.required = 1
[global]

### Change password of FE User
[globalVar = TSFE:id = {$pages.changeUserPasswordPageUid}, TSFE:type = 108]
    plugin.tx_femanager.settings.edit.pageType = 108
[global]

/*
[globalVar = TSFE:id = 9, TSFE:type = 109]
    plugin.tx_femanager.settings.changemobilenumber.pageType = 109
[global]
*/