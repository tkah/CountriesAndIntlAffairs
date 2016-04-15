import numpy as np
import glob
import csv
from sets import Set

def pad(n):
  if len(n)<2:
    rslt="00"+n
  elif len(n)<3:
    rslt="0"+n
  else:
    rslt=n
  return rslt

def strcsv(treatyNumber,ctryNumber):
  rslt=treatyNumber+','+ctryNumber+'\n'
  return rslt
    
ctrylist=np.genfromtxt('../db_resources/t/ctryDict.csv',delimiter=',',dtype='str')

ctryDict={}
for tmp in ctrylist:
  ctryDict[tmp[0]]=pad(tmp[1])
  print(ctryDict[tmp[0]])
  
infiles = glob.glob('../db_resources/t/t*.csv')
outfile = open('../db_resources/t/outTreaty.csv','w')
keSet=Set([]) #key-error-set
for f in infiles:
  trtylist=np.genfromtxt(f,delimiter=',',dtype='str',skip_header=1)
  treatyNumber=f[3:f.find('.csv')]
  for party in trtylist:
    try:
      countryNumber=ctryDict[party]
      #print(strcsv(treatyNumber,countryNumber))
      outfile.write(strcsv(treatyNumber,countryNumber))
    except KeyError:
      keSet.add(party)  
outfile.close()      
print(keSet)
