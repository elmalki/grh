<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">

        <title>Mission Print</title>
    
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
                    <img  align="right"src="images/logo_maroc.png" width="50px" height="50px"/>
                </td>
              
            </tr>
            <tr >
                
                <td style="width: 33%;"></td>
                <td style="text-align: center;border-bottom: 1px double black">
                    
                    <h5>Ordre de Mission N° : {{$mission->id}}</h5>
                </td>
                <td style="width: 33%;"></td>
            </tr>
            <tr>
                <td style="width: 33%; padding-left: 90px">
                    
                    <h5> Nom Et Prénom :</h5>
                </td>
                <td style="width: 33%;">
                        
                <h5>{{$mission->fonctionnaire->nom}} {{$mission->fonctionnaire->prenom}}</h5>
                </td>
                <td style="width: 33%;"></td>

            </tr>
            <tr>
                <td style="width: 33%;  padding-left: 90px">
                        
                    <h5>Grade :</h5>
                </td>
                <td style="width: 33%;">
                        
                    <h5>{{$mission->fonctionnaire->grade->libelle}}</h5>
                </td>
                <td style="width: 33%;"></td>

            </tr>
            <tr>
                    <td style="width: 33%;  padding-left: 90px">
                            
                        <h5>Déstination :</h5>
                    </td>
                    <td style="width: 33%;">
                            
                        <h5>{{$mission->deplacement->destination}}</h5>
                    </td>
                    <td style="width: 33%;"></td>
    
                </tr>
                <tr>
                            <td style="width: 33%;  padding-left: 90px">
                                    
                                <h5>Nature :</h5>
                            </td>
                            <td style="width: 33%;">
                                    
                                <h5>{{$mission->nature->libelle}}</h5>
                            </td>
                            <td style="width: 33%;"></td>
            
                        </tr>
                <tr>
                        <td style="width: 33%;  padding-left: 90px">
                                
                            <h5>Date Départ :</h5>
                        </td>
                        <td style="width: 33%;">
                                
                            <h5>{{$mission->dateDepart}}</h5>
                        </td>
                        <td style="width: 33%;"></td>
        
                    </tr>
                    <tr>
                        <td style="width: 33%;  padding-left: 90px">
                                
                            <h5>Date Retour :</h5>
                        </td>
                        <td style="width: 33%;">
                                
                            <h5>{{$mission->dateArrive}}</h5>
                        </td>
                        <td style="width: 33%;"></td>
        
                    </tr>
        </table>
    </div>
</body>
</html>