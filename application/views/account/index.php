<!DOCTYPE html>

<div ng-controller="AccountController">
    <md-content layout-padding class="container">
		
		<md-tab label="Historique de mes économies">
			<md-content class="md-padding">
			</md-content>
      	</md-tab>
		
		<md-tab label="Modifier ma liste d’épicerie">
			<md-content class="md-padding">
				<md-button class="md-primary md-raised" ng-click="changeGroceryList()">Modifier ma liste d'épicerie</md-button>
			</md-content>
      	</md-tab>
		
		<md-tab label="Modifier mes magasins préférés">
			<md-content class="md-padding">
				<md-button class="md-primary md-raised" ng-click="changeGroceryList()">Modifier ma liste de magasin préféré</md-button>
			</md-content>
      	</md-tab>
		
		<md-tab label="Modifier mes renseignements personnels">
			
			<div class="alert alert-warning">
			  	<strong>Warning!</strong> Indicates a warning that might need attention.
			</div>
			<div class="alert alert-success">
			  	<strong>Warning!</strong> Indicates a warning that might need attention.
			</div>

			<md-content class="md-padding">
				<form name="userInfoForm" novalidate>
					
					<md-input-container class="md-block col-md-12 col-sm-12" flex-gt-sm>
						<label>Email</label>
						<md-icon style="color: #1abc9c;"><i class="material-icons">email</i></md-icon>
						<input disabled="true" style="border-left: none; border-top: none; border-right: none;" type="email" name="email" ng-model="loggedUser.email" />
					</md-input-container>
					
					 <!-- -->
                    <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                        <label>Prenom</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">person</i></md-icon>
                        <input name="firstname" ng-model="loggedUser.firstname" />
                    </md-input-container>

                    <!-- -->
                    <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                        <label>Nom</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">person</i></md-icon>
                        <input required name="lastname" ng-model="loggedUser.lastname" />
                        <div ng-messages="userInfoForm.lastname.$error">
                            <div ng-message="required">Vous devez entrer au moins un nom</div>
                        </div>
                    </md-input-container>

                    <!--Select the country and state origin of the product-->
                    <country-state-select country="loggedUser.country" flag="icons.flag" country-state="loggedUser.state" show-hints="showHints"></country-state-select>

                    <md-input-container class="md-block col-md-12 col-sm-12" flex-gt-sm>
                        <label>Adresse</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                        <input required name="address" ng-model="loggedUser.address" />
                        <div ng-messages="userInfoForm.address.$error">
                            <div ng-message="required">Vous devez entrer une adresse</div>
                        </div>
                    </md-input-container>
                    <!-- -->
                    <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                        <label>City</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                        <input required name="city" ng-model="loggedUser.city" />
                        <div ng-messages="userInfoForm.city.$error">
                            <div ng-message="required">Vous devex entrer une ville</div>
                        </div>
                    </md-input-container>
                    <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                        <label>Code Postal</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">place</i></md-icon>
                        <input required name="postcode" ng-model="loggedUser.postcode" />
                        <div ng-messages="userInfoForm.postcode.$error">
                            <div ng-message="required">Veillez entrer votre code postale</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                        <label>Numbero de telephone principale</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">local_phone</i></md-icon>
                        <input name="phone1" ng-model="loggedUser.phone1" />
                    </md-input-container>

                    <md-input-container class="md-block col-md-6 col-sm-12" flex-gt-sm>
                        <label>Numbero de telephone secondaire</label>
                        <md-icon style="color: #1abc9c;"><i class="material-icons">local_phone</i></md-icon>
                        <input name="phone2" ng-model="loggedUser.phone2" />
                    </md-input-container>
					
					<div class="pull-right">
						<input type="submit" class="btn btn-primary" value="Changer" />
					</div>
				</form>
			</md-content>
      	</md-tab>
		
		<md-tab label="Sécurité du compte">
			
			<div class="alert alert-warning">
			  	<strong>Warning!</strong> Indicates a warning that might need attention.
			</div>
			<div class="alert alert-success">
			  	<strong>Warning!</strong> Indicates a warning that might need attention.
			</div>
			
			<md-content class="md-padding">
				<form name="userSecurityForm" novalidate>
					<md-input-container class="md-block col-md-12" flex-gt-sm>
						<label>Email</label>
						<md-icon style="color: #1abc9c;"><i class="material-icons">email</i></md-icon>
						<input disabled="true" style="border-left: none; border-top: none; border-right: none;" type="email" name="email" ng-model="loggedUser.email" />
					</md-input-container>
					
					<md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
						<label>Ancien mot de passe</label>
						<md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
						<input style="border-left : none; border-right : none;border-top : none;" type="password" required name="old_password" ng-model="user.old_password" />
						<div ng-messages="userSecurityForm.old_password.$error">
							<div ng-message="required">Vous devez confirmer votre ancien mot de passe.</div>
						</div>
					</md-input-container>

					<md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
						<label>Mot de passe</label>
						<md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
						<input style="border-left : none; border-right : none;border-top : none;" type="password" required name="password" ng-model="user.password" equals="{{user.confirm_password}}" ng-pattern="/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/" />
						<div ng-messages="userSecurityForm.password.$error">
							<div ng-message="required">Un mot de passe est requis.</div>
							<div ng-message="pattern">Le mot de passe n'est pas assez fort. Le mot de passe doit comporter au moins 8 caractères et doit contenir un nombre, un caractère et un caractère spécial.</div>
							<div ng-message="equals">Les mots de passe ne correspondent pas.</div>
						</div>
					</md-input-container>

					<md-input-container class="md-block col-md-4 col-sm-12" flex-gt-sm>
						<label>Confirmer mot de passe</label>
						<md-icon style="color: #1abc9c;"><i class="material-icons">lock</i></md-icon>
						<input style="border-left : none; border-right : none;border-top : none;" type="password" required name="confirm_password" ng-model="user.confirm_password" equals="{{user.password}}" />
						<div ng-messages="userSecurityForm.confirm_password.$error">
							<div ng-message="required">Vous devez confirmer votre mot de passe.</div>
							<div ng-message="equals">Les mots de passe ne correspondent pas.</div>
						</div>
					</md-input-container>
					
					<div class="pull-right">
						<input type="submit" class="btn btn-primary" value="Changer" />
					</div>
				</form>
				
				<form name="securityQuestionForm" novalidate>
					<div class="alert alert-warning">
			  			<strong>Warning!</strong> Indicates a warning that might need attention.
					</div>
					<div class="alert alert-success">
						<strong>Warning!</strong> Indicates a warning that might need attention.
					</div>
					
					<md-content class="md-padding">
						<md-input-container class="md-block col-md-12" flex-gt-sm>
							<label>Question secrète</label>
							<md-select ng-model="user.security_question_id">
								<md-option ng-value="$index" ng-repeat="question in securityQuestions">{{ question }}</md-option>
							</md-select>
						</md-input-container>

						<md-input-container class="md-block col-md-12" flex-gt-sm>
							<label>Reponse</label>
							<input required name="response" ng-model="user.security_question_answer" />
							<div ng-messages="securityQuestionForm.response.$error" ng-if="!showHints">
								<div ng-message="required">Une réponse de sécurité est nécessaire..</div>
							</div>
						</md-input-container>
						
						<div class="pull-right">
							<input type="submit" class="btn btn-primary" value="Changer" />
						</div>
					<md-content>
				</form>
			</md-content>
      	</md-tab>
    </md-content>
</div>
 

