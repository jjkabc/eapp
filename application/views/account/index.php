<!DOCTYPE html>

<div ng-controller="AccountController">
    <md-content layout-padding class="container">
        <fieldset>
            <legend>Historique de mes économies</legend>
        </fieldset>

        <fieldset>
            <legend>Modifier ma liste d’épicerie</legend>
        </fieldset>

        <fieldset>
            <legend>Modifier mes magasins préférés</legend>
            <form>
                
            </form>
        </fieldset>


            
        
        <md-content layout-padding>
            
            <md-toolbar md-scroll-shrink>
                <div class="md-toolbar-tools">Modifier mes renseignements personnels</div>
            </md-toolbar>
            
            <section>
                
                    
                    <md-input-container class="md-block col-md-12" flex-gt-sm>
                        <label>Email</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">email</i></md-icon>
                        <input disabled="true" style="border-left: none; border-top: none; border-right: none;" type="email" name="email" ng-model="loggedUser.email" />
                    </md-input-container>
                    <form>
                    
                        <md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
                            <label>Ancien mot de passe</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
                            <input style="border-left : none; border-right : none;border-top : none;" type="password" required name="old_password" ng-model="user.old_password" />
                            <div ng-messages="signupForm.old_password.$error">
                                <div ng-message="required">Vous devez confirmer votre ancien mot de passe.</div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
                            <label>Mot de passe</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
                            <input style="border-left : none; border-right : none;border-top : none;" type="password" required name="password" ng-model="user.password" equals="{{user.confirm_password}}" ng-pattern="/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/" />
                            <div ng-messages="signupForm.password.$error">
                                <div ng-message="required">Un mot de passe est requis.</div>
                                <div ng-message="pattern">Le mot de passe n'est pas assez fort. Le mot de passe doit comporter au moins 8 caractères et doit contenir un nombre, un caractère et un caractère spécial.</div>
                                <div ng-message="equals">Les mots de passe ne correspondent pas.</div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
                            <label>Confirmer mot de passe</label>
                            <md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
                            <input style="border-left : none; border-right : none;border-top : none;" type="password" required name="confirm_password" ng-model="user.confirm_password" equals="{{user.password}}" />
                            <div ng-messages="signupForm.confirm_password.$error">
                                <div ng-message="required">Vous devez confirmer votre mot de passe.</div>
                                <div ng-message="equals">Les mots de passe ne correspondent pas.</div>
                            </div>
                        </md-input-container>
                        
                        <div class="pull-right">
                            <input type="submit" class="btn btn-primary" value="Changer" />
                        </div>
                        
                    </form> 
                    
                    <md-input-container class="md-block col-md-12" flex-gt-sm>
                        <label>Question secrète</label>
                        <md-select ng-model="user.security_question_id">
                            <md-option ng-value="$index" ng-repeat="question in securityQuestions">{{ question }}</md-option>
                        </md-select>
                    </md-input-container>
                        

                    <md-input-container class="md-block col-md-12" flex-gt-sm>
                        <label>Reponse</label>
                        <input required name="response" ng-model="user.security_question_answer" />
                        <div ng-messages="signupForm.response.$error" ng-if="!showHints">
                            <div ng-message="required">Une réponse de sécurité est nécessaire..</div>
                        </div>
                    </md-input-container>
                
            </section>
        
            <section>
                <form>
                    
                    <!-- -->
                    <md-input-container class="md-block col-md-6" flex-gt-sm>
                        <label>Prenom</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">person</i></md-icon>
                        <input name="firstname" ng-model="user.firstname" />
                    </md-input-container>

                    <!-- -->
                    <md-input-container class="md-block col-md-6" flex-gt-sm>
                        <label>Nom</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">person</i></md-icon>
                        <input required name="lastname" ng-model="user.lastname" />
                        <div ng-messages="signupForm.lastname.$error">
                            <div ng-message="required">Vous devez entrer au moins un nom</div>
                        </div>
                    </md-input-container>

                    <!--Select the country and state origin of the product-->
                    <country-state-select country="user.country" flag="icons.flag" country-state="user.state" show-hints="showHints"></country-state-select>

                    <md-input-container class="md-block col-md-12" flex-gt-sm>
                        <label>Adresse</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                        <input required name="address" ng-model="user.address" />
                        <div ng-messages="signupForm.address.$error">
                            <div ng-message="required">Vous devez entrer une adresse</div>
                        </div>
                    </md-input-container>
                    <!-- -->
                    <md-input-container class="md-block col-md-6" flex-gt-sm>
                        <label>City</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                        <input required name="city" ng-model="user.city" />
                        <div ng-messages="signupForm.city.$error">
                            <div ng-message="required">Vous devex entrer une ville</div>
                        </div>
                    </md-input-container>
                    <md-input-container class="md-block col-md-6" flex-gt-sm>
                        <label>Code Postal</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                        <input required name="postcode" ng-model="user.postcode" />
                        <div ng-messages="signupForm.postcode.$error">
                            <div ng-message="required">Veillez entrer votre code postale</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block col-md-6" flex-gt-sm>
                        <label>Numbero de telephone principale</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">local_phone</i></md-icon>
                        <input name="phone1" ng-model="user.phone1" />
                    </md-input-container>

                    <md-input-container class="md-block col-md-6" flex-gt-sm>
                        <label>Numbero de telephone secondaire</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">local_phone</i></md-icon>
                        <input name="phone2" ng-model="user.phone2" />
                    </md-input-container>
                    
                </form> 
            </section>
        </md-content>
            
            
        
            
            


        
    </md-content>
</div>
 

