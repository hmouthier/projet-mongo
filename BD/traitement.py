import pymongo

from pymongo import MongoClient
client = MongoClient('localhost', 27017)
db = client.db_educ

loc = db.local
val = db.val
sortie = db.sortie




i=0
for postval in val.find():
	for postlocal in loc.find({"code_nature":{ "$gte": 300, "$lte": 319 }}):
		if(postval["numero_uai"]==postlocal["numero_uai"]):
			new_posts = [{"numero": postval["numero_uai"],"nom": postlocal["appellation_officielle_uai"],"X": postlocal["X"],"Y": postlocal["Y"],"reussite": postval["reussite_total"]}]
			i=i+1
			print i
			sortie.insert(new_posts)


