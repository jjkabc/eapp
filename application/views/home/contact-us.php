<!DOCTYPE html>

<div class="container">
    
    <a href="<?php echo site_url("home/goback"); ?>">Retour</a>
    
    <div class="row col-sm-12">
       <div class="offset-md-3 col-md-12" ng-controller="HomeController">
        
        <div class="row col-sm-12">
            <img src="<?php echo base_url("/assets/img/contact-us.png"); ?>" width="100%"/>
        </div>
        
        <div class="row">
            <md-input-container class="col-sm-12">
                <label>Nom</label>
                <input ng-model="contactName" />
            </md-input-container>
            
        </div>
        <div class="row">
            <md-input-container class="col-sm-12">
                <label>Email</label>
                <input ng-model="contactEmail" />
            </md-input-container>
        </div>
        <div class="row">
            <md-input-container class="col-sm-12">
                <label>Sujet</label>
                <input ng-model="contactSubject" />
            </md-input-container>
        </div>
        <div class="row">
            <md-input-container class="col-sm-12">
                <label>Commetns</label>
                <textarea ng-model="contactComment" md-maxlength="150" rows="5" md-select-on-focus></textarea>
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
