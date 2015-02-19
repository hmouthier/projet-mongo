#!/usr/bin/env python
# -*- coding: utf-8 -*-
import pymongo
try:
    from osgeo import ogr
except:
    import ogr
try:
    from osgeo import osr
except:
    import osr



def transformation(x,y):
    refLambert = osr.SpatialReference()
    refLambert.ImportFromEPSG(2154)
    refLonLat = osr.SpatialReference()
    refLonLat.ImportFromEPSG(4326)
    coordTrans = osr.CoordinateTransformation(refLambert,refLonLat)
    point = ogr.Geometry(ogr.wkbPoint)
    point.AddPoint(x,y)
    point.Transform(coordTrans)
    return point





def is_number(s):
    try:
        float(s)
        return True
    except ValueError:
        return False



from pymongo import MongoClient
client = MongoClient('localhost', 27017)
db = client.db_educ


f = open('loc.csv', 'r')
posts = db.local

next(f)
for row in f:
    liste=row.split(";")
    if is_number(liste[4]) and is_number(liste[5]):
        point=transformation(float(liste[4]),float(liste[5]))
        new_posts = [{"numero_uai": unicode(liste[0],'utf-8'),
                  "appellation_officielle_uai": unicode(liste[1],'utf-8'),
                 "X": point.GetX(),
                 "Y": point.GetY(),
                 "code_nature": float(liste[7]),
                 "lib_nature": unicode(liste[8],'utf-8')}]
        posts.insert(new_posts)
print "import de la localisation terminée"

f = open('val.csv', 'r')
posts = db.val

next(f)
for row in f:
	liste=row.split(";")
	new_posts = [{"numero_uai": unicode(liste[2],'utf-8'),
              "secteur": unicode(liste[4],'utf-8'),
             "effectif_L": unicode(liste[5],'utf-8'),
             "effectif_ES": unicode(liste[6],'utf-8'),
             "effectif_S": unicode(liste[7],'utf-8'),
             "effectif_STG": unicode(liste[8],'utf-8'),
             "effectif_STI": unicode(liste[9],'utf-8'),
             "effectif_STL": unicode(liste[10],'utf-8'),
             "effectif_ST2S": unicode(liste[11],'utf-8'),
             "effectif_total": unicode(liste[14],'utf-8'),
             "reussite_L": unicode(liste[15],'utf-8'),
             "reussite_ES": unicode(liste[16],'utf-8'),
             "reussite_S": unicode(liste[19],'utf-8'),
             "reussite_STG": unicode(liste[20],'utf-8'),
             "reussite_STI": unicode(liste[21],'utf-8'),
             "reussite_STL": unicode(liste[22],'utf-8'),
             "reussite_ST2S": unicode(liste[23],'utf-8'),
             "reussite_total": unicode(liste[24],'utf-8')}]
	posts.insert(new_posts)
print "import de la réussite au bac terminée"