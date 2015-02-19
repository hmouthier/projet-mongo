function graphe_camembert(donnees,legendes) {
			
				var canvas = document.getElementById('camembert');
				var context = canvas.getContext('2d');
				
				// donnees en pourcentage
				var donnees = [1,4,11,21,37,26];
				
				var diametre = Math.min(canvas.height, canvas.width) - 150;
				var rayon = diametre / 2;
				
				// position du centre du camembert
				var position_x = rayon + 20;
				var position_y = canvas.height / 2 + 20;
				
				var nb_donnees = donnees.length;
				var angle_initial = 0;
				// var stylecolors = ['fuchsia', 'orange', 'tan', 'rgb(0,0,255)', 'rgb(0,255,0)', 'rgb(255,0,0)'];
				
				var largeur_rect = 15;
				// var legendes = ['10 minutes','30 minutes','50 minutes','60 minutes','90 minutes','120 minutes'];
				
				for(var i=0;i<nb_donnees; i++) {
					var angles_degre = (donnees[i] / 100) * 360;// conversion pourcentage -> angle en degré
					DessinerAngle(context,position_x,position_y,rayon,angle_initial,angles_degre,stylecolors[i]);
					angle_initial += angles_degre;
					
					DessinerRectangle(
						context,
						diametre + 30,
						(largeur_rect + 3) * (i + 1),
						largeur_rect,largeur_rect,
						stylecolors[i]
					);
					context.font = '9pt Tahoma';//legendes
					context.fillStyle = '#000';//legendes
					context.fillText(legendes[i] + ', ' + donnees[i] +' %',diametre + 55,18 * i+30);//legendes
				}
				context.fillText('La semaine',diametre+50,150);
			}
			// petit rectangle pour la légende
			function DessinerRectangle(context,x0,y0,xl,yl,coloration) {
				context.beginPath();
				context.fillStyle = coloration;
				context.fillRect(x0,y0,xl,yl);
				context.closePath();
				context.fill();
			}
			function DessinerAngle(context,position_x,position_y,rayon,angle_initial,angles_degre,couleurs) {
				context.beginPath();
				context.fillStyle  = couleurs;
				var angle_initial_radian = angle_initial / (180 / Math.PI);// conversion angle en degré -> angle en radian
				var angles_radian = angles_degre / (180 / Math.PI);// conversion angle en degré -> angle en radian
				context.arc(position_x,position_y,rayon,angle_initial_radian,angle_initial_radian + angles_radian,0);
				context.lineTo(position_x, position_y);
				context.closePath();
				context.fill();
			}

			 // window.addEventListener("load", graphe_camembert, false);
						



/////////// BARRES




						function diagramme_rectangulaire( ) {
				var canvas = document.getElementById('diagramme');
				var context = canvas.getContext('2d');
				
				// Données statistiques
				var minutes = ['80','90','85','100'];
				var ages = ['S','ES','L','STI'];
				
				// Origine du repère
				context.translate(50,220);
				var x0 = 0;
				var y0 = 0;
				
				var largeur_barre = 50;
				context.lineWidth = '1.0';
				
				// Couleur et largeur du trait
				context.fillStyle = '#000';
				context.lineWidth = '1.0';
				
				// Axe des ordonnées
				tracer (context,x0,y0,x0,-270);
				// Flèche
				tracer (context,x0-8,-260+3,x0,-270);
				tracer (context,x0+8,-260+3,x0,-270);
				
				context.textAlign = 'center';
				context.font = '9pt Tahoma';
				var graduation = 0;
				var pas = 20;
				for (var i=0; i<13; i++) {
					tracer (context,x0-3,y0-20*(i),x0+3,y0-20*(i));
					graduation = pas*i;
					context.fillText(graduation, (x0 - 20), (y0 - graduation+4));
				}
				context.fillText('Minutes par semaine', (x0 ), (y0 - 280));
				
				// Axe des abscisses
				tracer (context,x0,y0,420,y0);
				// Flèche
				tracer (context,410-3,y0-8,410+10,y0);
				tracer (context,410-3,y0+8,410+10,y0);
				
				context.textAlign = 'left';
				context.fillText('Groupe d\'âge', x0 + canvas.width - 260, y0 + 60);
				
				context.lineWidth = '1.0';
				// Tracée du diagramme rectangulaire, légende de l'axe des abscisses
				for (i=0; i<minutes.length; i++) {
					context.fillStyle = 'grey';				
					context.beginPath();
					context.rect(x0+10 + (i * largeur_barre) +5*i, y0 -1 - minutes[i], largeur_barre, minutes[i]);
					context.closePath();
					context.stroke();
					context.fill();
					context.fillStyle = '#000';
					var mesure_texte = context.measureText(ages [i]).width;
					var centrer_texte = (largeur_barre - mesure_texte)/2;
					context.fillText(ages[i], x0+10 +centrer_texte + (i * largeur_barre) + 5*i, y0 + 18);
				}
			}
			// Fonction de tracer de trait
			function tracer (ctx,x1,y1,x2,y2)  {
				ctx.beginPath();
				ctx.moveTo(x1, y1);
				ctx.lineTo(x2, y2);
				ctx.closePath();
				ctx.stroke();
			}
			 window.addEventListener('load', diagramme_rectangulaire, false);