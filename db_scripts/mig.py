import numpy as np
import glob

def pad(n):
  if n<10:
    rslt="00"+str(n)
  elif n<100:
    rslt="0"+str(n)
  else:
    rslt=str(n)
  return rslt

def strcsv(d,o,y,a):
  rslt=d+','+o+','+y+','+str(a)+'\n'
  return rslt
    
ch=np.genfromtxt('../db_resources/countryHorizontal.csv',delimiter=',',dtype=int)
cv=np.genfromtxt('../db_resources/countryVertical.csv',delimiter=',',dtype=int)
dich={}
dicv={}
i=0
for tmp in ch:
  dich[i]=pad(tmp)
  print(i,dich[i])
  i=i+1
i=0
for tmp in cv:
  dicv[i]=pad(tmp)
  print(i,dicv[i])
  i=i+1
  
infiles = glob.glob('../db_resources/m*.csv')
outfile = open('../db_resources/mig.csv','w')
for f in infiles:
    mg=[]
    idx=[]
    yyyy=f[3:7]
    mg=np.genfromtxt(f,delimiter=',',dtype=int,skip_header=1)[:,1:-1]
    idx=np.column_stack(np.where(mg>0))
    for id in idx:
      dest=dicv[id[0]]
      orig=dich[id[1]]
      amt=mg[id[0]][id[1]]
      outfile.write(strcsv(dest,orig,yyyy,amt))
outfile.close()      

