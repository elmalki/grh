<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">

        <title>Attestation de Travail</title>
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <table style="width: 100%;  border: 2px dotted black;">
            <tr>
                <td style="text-align: center; width: 33%">
                   <h5>
                    Royaume du Maroc <br>
                    Ministère de l'intérieur <br>
                    Province Chtouka Ait Baha <br>
                    Secrétariat Général
                </h5>
                </td>
                <td style="width: 33%;" ></td>
                <td style="width: 33%; padding-right: 30px; padding-top: 15px">
                    <img  align="right" src="images/logo_maroc.png" width="50px" height="50px"/>
                </td>
              
            </tr>
            <tr >
                
                <td style="width: 33%;"></td>
                <td style="text-align: center;border-bottom: 1px double black">
                    
                    <h5>ATTESTATTION DE TRAVAIL</h5>
                </td>
                <td style="width: 33%;"></td>
            </tr>
            <tr>
                <td style="width: 33%; padding-left: 90px">
                    
                    <h5> Nom Et Prénom :</h5>
                </td>
                <td style="width: 33%;">
                        
                <h5>{{$fonctionnaire->nom}} {{$fonctionnaire->prenom}}</h5>
                </td>
                <td style="width: 33%;"></td>

            </tr>
            <tr>
                <td style="width: 33%; padding-left: 90px">
                    
                    <h5> CIN :</h5>
                </td>
                <td style="width: 33%;">
                        
                <h5>{{$fonctionnaire->cin}}</h5>
                </td>
                <td style="width: 33%;"></td>

            </tr>
            <tr>
                <td style="width: 33%;  padding-left: 90px">
                        
                    <h5>Grade :</h5>
                </td>
                <td style="width: 33%;">
                        
                    <h5>{{$fonctionnaire->grade->libelle}}</h5>
                </td>
                <td style="width: 33%;"></td>

            </tr>
            <tr>
                <td style="width: 33%;  padding-left: 90px">
                        
                    <h5>Affectation :</h5>
                </td>
                <td style="width: 33%;">
                        
                    <h5>{{$fonctionnaire->division->libelle}}</h5>
                </td>
                <td style="width: 33%;"></td>

            </tr>
            <tr>
                <td style="width: 33%;  padding-left: 90px">
                        
                    <h5>Date de Recrutement :</h5>
                </td>
                <td style="width: 33%;">
                        
                    <h5>add to migration</h5>
                </td>
                <td style="width: 33%;"></td>

            </tr>
            <tr>
                <td style="width: 33%;  padding-left: 90px" colspan="3">
                        
                    <h5>
                        Est en fonction à cette province jusqu'à ce jour.
                        La présente attestation est établie sur la demande de l'intéressé(e) pour la constitution d'un dossier à usage administratif
                    </h5>
                </td>

            </tr>
        </table>
    </div>
</body>
</html>