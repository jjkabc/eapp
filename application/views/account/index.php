<!DOCTYPE html>

<script>
    $(document).ready(function()
    {
        var scope = angular.element($("#admin-container")).scope();
    
        scope.$apply(function()
        {
           scope.load_icons(); 
           
           scope.getUserProductList();
           
           scope.retailers = JSON.parse('<?php echo $retailers; ?>');
        
            if(sessionStorage.getItem("registered_email") || scope.isUserLogged)
            {
                if(sessionStorage.getItem("registered_email"))
                {
                    scope.registered_email = sessionStorage.getItem("registered_email");
                    window.sessionStorage.removeItem("registered_email");
                }
                else
                {
                    scope.registered_email = scope.loggedUser.email;
                }
            }
            else
            {
                // redirect to home page
                window.location = scope.site_url.concat("/home");
            }
        });
        
    });
    
</script>



<div id="admin-container" ng-controller="AccountController">
    <md-tabs md-dynamic-height md-border-bottom class="container" layout-padding>
        
        <md-content>
		
            <md-tab label="Modifier mes renseignements personnels">

                <div class="alert alert-danger" ng-show="saveProfileError">
                    <strong>Erreur!</strong> {{saveProfileErrorMessage}}.
                </div>
                
                <div class="alert alert-success" ng-show="saveProfileSucess">
                    <strong>Success!</strong> {{saveProfileSuccessMessage}}
                </div>

                <md-content class="md-padding">
                    <form name="userInfoForm" novalidate ng-submit="saveProfile()">
                        <md-input-container class="md-block col-md-12 col-sm-12" flex-gt-sm>
                            <label>Email</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">email</i></md-icon>
                            <input disabled="true" style="border-left: none; border-top: none; border-right: none;" type="email" name="email" ng-model="loggedUser.email" />
                        </md-input-container>
                        <!-- -->
                        <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                            <label>Prenom</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">person</i></md-icon>
                            <input name="profile[firstname]" ng-model="loggedUser.profile.firstname" />
                        </md-input-container>
                        <!-- -->
                        <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                            <label>Nom</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">person</i></md-icon>
                            <input required name="profile[lastname]" ng-model="loggedUser.profile.lastname" />
                            <div ng-messages="userInfoForm.lastname.$error">
                                <div ng-message="required">Vous devez entrer au moins un nom</div>
                            </div>
                        </md-input-container>

                        <!--Select the country and state origin of the product-->
                        <country-state-select country="loggedUser.profile.country" flag="icons.flag" country-state="loggedUser.profile.state" show-hints="showHints"></country-state-select>

                        <md-input-container class="md-block col-md-12 col-sm-12" flex-gt-sm>
                            <label>Adresse</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                            <input required name="profile[address]" ng-model="loggedUser.profile.address" />
                            <div ng-messages="userInfoForm.address.$error">
                                <div ng-message="required">Vous devez entrer une adresse</div>
                            </div>
                        </md-input-container>
                        <!-- -->
                        <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                            <label>City</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                            <input required name="profile[city]" ng-model="loggedUser.profile.city" />
                            <div ng-messages="userInfoForm.city.$error">
                                <div ng-message="required">Vous devex entrer une ville</div>
                            </div>
                        </md-input-container>
                        <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                            <label>Code Postal</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                            <input required name="profile[postcode]" ng-model="loggedUser.profile.postcode" />
                            <div ng-messages="userInfoForm.postcode.$error">
                                <div ng-message="required">Veillez entrer votre code postale</div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                            <label>Numbero de telephone principale</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">local_phone</i></md-icon>
                            <input name="profile[phone1]" ng-model="loggedUser.profile.phone1" />
                        </md-input-container>

                        <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                            <label>Numbero de telephone secondaire</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">local_phone</i></md-icon>
                            <input name="profile[phone2]" ng-model="loggedUser.profile.phone2" />
                        </md-input-container>

                        <div class="pull-right">
                            <input type="submit" class="btn btn-primary" value="Changer" />
                        </div>
                        
                    </form>
                </md-content>
            </md-tab>
            
            <md-tab label="Historique de mes économies">
                <md-content class="md-padding">
                </md-content>
            </md-tab>

            <md-tab label="Modifier ma liste d’épicerie">
                <div id="groceryListContainer" ng-include="'<?php echo base_url(); ?>/assets/templates/user_grocery_list.html'"></div>
            </md-tab>

            <md-tab label="Modifier mes magasins préférés">
                <div class="alert alert-success" ng-show="listChangedSuccess">
                    <strong>Success!</strong> {{listChangedSuccessMessage}}
                </div>
                <div id="select-store-container" ng-include="'<?php echo base_url(); ?>/assets/templates/select-favorite-stores.html'"></div>
                <div class="form-group">
                    <!-- Button -->                                        
                    <div class="col-md-offset-0 col-md-3 pull-right" style="padding-top:25px;">
                        <button id="btn-signup"  ng-click="submit_favorite_stores()" type="submit" class="btn btn-info col-md-12"><i class="icon-hand-right"></i> &nbsp Changer</button>
                    </div>
                </div>
            </md-tab>
           
            <md-tab label="Sécurité du compte">
                
                <md-content class="md-padding">
                    
                    <div class="alert alert-danger" ng-show="changePasswordError">
                        <strong>Erreur!</strong> {{changePasswordErrorMessage}}
                    </div>

                    <div class="alert alert-success" ng-show="changePasswordSuccess">
                        <strong>Success!</strong> {{changePasswordSuccessMessage}}
                    </div>
                    <form name="userSecurityForm" novalidate ng-submit="changePassword()">

                        <md-input-container class="md-block col-md-12" flex-gt-sm>
                            <label>Email</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">email</i></md-icon>
                            <input disabled="true" style="border-left: none; border-top: none; border-right: none;" type="email" name="email" ng-model="loggedUser.email" />
                        </md-input-container>

                        <md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
                            <label>Ancien mot de passe</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
                            <input style="border-left : none; border-right : none;border-top : none;" type="password" required name="old_password" ng-model="old_password" />
                            <div ng-messages="userSecurityForm.old_password.$error">
                                <div ng-message="required">Vous devez confirmer votre ancien mot de passe.</div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
                            <label>Mot de passe</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
                            <input style="border-left : none; border-right : none;border-top : none;" type="password" required name="password" ng-model="password" equals="{{confirm_password}}" ng-pattern="/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/" />
                            <div ng-messages="userSecurityForm.password.$error">
                                <div ng-message="required">Un mot de passe est requis.</div>
                                <div ng-message="pattern">Le mot de passe n'est pas assez fort. Le mot de passe doit comporter au moins 8 caractères et doit contenir un nombre, un caractère et un caractère spécial.</div>
                                <div ng-message="equals">Les mots de passe ne correspondent pas.</div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
                            <label>Confirmer mot de passe</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
                            <input style="border-left : none; border-right : none;border-top : none;" type="password" required name="confirm_password" ng-model="confirm_password" equals="{{password}}" />
                            <div ng-messages="userSecurityForm.confirm_password.$error">
                                <div ng-message="required">Vous devez confirmer votre mot de passe.</div>
                                <div ng-message="equals">Les mots de passe ne correspondent pas.</div>
                            </div>
                        </md-input-container>

                        <div class="pull-right">
                            <input type="submit" class="btn btn-primary" value="Changer" />
                        </div>

                    </form>
                </md-content>    
                
                <md-content class="md-padding">
                    <form name="securityQuestionForm" ng-submit="changeSecurityQuestion()" novalidate>

                        <div class="alert alert-danger" ng-show="changeSecurityQuestionError">
                            <strong>Erreur!</strong> {{changeSecurityQuestionErrorMessage}}
                        </div>

                        <div class="alert alert-success" ng-show="changeSecurityQuestionSuccess">
                            <strong>Success!</strong> {{changeSecurityQuestionSuccessMessage}}
                        </div>

                        <md-content class="md-padding">
                            <md-input-container class="md-block col-md-12" flex-gt-sm>
                                <label>Question secrète</label>
                                <md-select ng-model="loggedUser.security_question_id">
                                    <md-option ng-value="$index" ng-repeat="question in securityQuestions">{{ question }}</md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block col-md-12" flex-gt-sm>
                                <label>Reponse</label>
                                <input required name="response" ng-model="loggedUser.security_question_answer" />
                                <div ng-messages="securityQuestionForm.response.$error" ng-if="!showHints">
                                    <div ng-message="required">Une réponse de sécurité est nécessaire..</div>
                                </div>
                            </md-input-container>

                            <div class="pull-right">
                                <input type="submit" class="btn btn-primary" value="Changer" />
                            </div>
                        </md-content>

                    </form>
                </md-content>  
            </md-tab>
        </md-content>
    </md-tabs>
    
   
</div>
 

