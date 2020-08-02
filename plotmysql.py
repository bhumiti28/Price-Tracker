import sys
from pylab import *
import mysql.connector

db = mysql.connector.connect(host='localhost',user='root', password = None,db = 'price_tracking_final')
cursor = db.cursor()

cursor.execute('SELECT product_id, demand FROM quantity') 	
result = cursor.fetchall()

t = []
s = []

for record in result:
  t.append(record[0])
  s.append(record[1])

plot(t, s)
axis([min(t), max(t), min(s), max(s)])
title('Plot')
grid(True)

F = gcf()
DPI = F.get_dpi()
F.savefig('Desktop/plot.png',dpi = (80))
