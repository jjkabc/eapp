<!DOCTYPE html>

<div class="contact-us">
    <div class="container">
    
    <div class="row">
        <div class="col-md-12" ng-controller="HomeController">
        
            <div class="col-md-offset-6 col-md-6 col-sm-offset-0 col-sm-12" style="padding : 30px; background-color: white; margin-bottom: 10px;">
                 <div class="col-sm-12">
                     <md-input-container class="md-block" flex-gt-xs>
                         <label>Nom</label>
                         <input ng-model="contactName" />
                     </md-input-container>
                 </div>

                 <div class="col-sm-12">
                     <md-input-container class="md-block" flex-gt-xs>
                         <label>Email</label>
                         <input ng-model="contactEmail" />
                     </md-input-container>
                 </div>

                 <div class="col-sm-12">
                     <md-input-container class="md-block" flex-gt-xs>
                         <label>Sujet</label>
                         <input ng-model="contactSubject" />
                     </md-input-container>
                 </div>

                 <div class="col-sm-12">
                     <md-input-container class="md-block" flex-gt-xs>
                         <label>Commentaires</label>
                         <textarea ng-model="contactComment" md-maxlength="100" rows="5" md-select-on-focus></textarea>
                     </md-input-container>
                 </div>

                 <div class="row pull-right">
                     <md-button class="md-otiprix md-raised">
                         Envoyer
                     </md-button>
                 </div>
            </div>   
        
        </div> 
    </div>
    
    
</div>
</div>

