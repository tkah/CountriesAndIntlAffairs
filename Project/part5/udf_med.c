   #ifdef STANDARD
   /* STANDARD is defined, don't use any mysql functions */
   #include <stdlib.h>
   #include <stdio.h>
   #include <string.h>
   #ifdef __WIN__
   typedef unsigned __int64 ulonglong;/* Microsofts 64 bit types */
   typedef __int64 longlong;
   #else
   typedef unsigned long long ulonglong;
   typedef long long longlong;
   #endif /*__WIN__*/
   #else
   #include <my_global.h>
   #include <my_sys.h>
   #if defined(MYSQL_SERVER)
   #include <m_string.h>/* To get strmov() */
   #include <m_ctype.h>
   #else
   /* when compiled as standalone */
   #include <string.h>
   #define strmov(a,b) stpcpy(a,b)
   #define bzero(a,b) memset(a,0,b)
   #define memcpy_fixed(a,b,c) memcpy(a,b,c)
   #endif
   #endif
   #include <mysql.h>
   #include <ctype.h>
   
   #ifdef HAVE_DLOPEN
   
   #if !defined(HAVE_GETHOSTBYADDR_R) || !defined(HAVE_SOLARIS_STYLE_GETHOST)
   static pthread_mutex_t LOCK_hostname;
   #endif
   
   //                                                                        
   // User #includes go here                                                 
   //
   #include "qksrt.h"
   #define MAXGRP 500
   unsigned long x[MAXGRP];
   unsigned	long count;
   my_bool median_udf_init(UDF_INIT *initid, UDF_ARGS *args, char *message)
   {
     if(!(args->arg_count == 1)) {
       strcpy(message, "Expected One arguments (totalAmount)");
       return 1;
     }
     args->arg_type[0] = INT_RESULT;
     return 0;
   }
   
   void median_udf_deinit(UDF_INIT *initid)
   {
   }
   
   void median_udf_add( UDF_INIT* initid, UDF_ARGS* args, 
	char* is_null, char *error ) {
	int idx=count;
	x[idx]=*((unsigned long *)args->args[0]);
    count++;
   }
   
   void median_udf_clear( UDF_INIT* initid, UDF_ARGS* args, 
	    char* is_null, char *error ) {
	    int i;
	    for(i=0;i<MAXGRP;i++){
	        x[i]=0;
	    }
        count = 0;
   }

   unsigned long median_udf(UDF_INIT* initid, UDF_ARGS* args __attribute__((unused)),
                        char* is_null __attribute__((unused)), char* error __attribute__((unused)))
   {
     quicksort(x,0,count-1);
     if(count%2==0){
        return x[count/2-1];
     }else{        
        return x[(count+1)/2-1];
     }
   }

   #endif /* HAVE_DLOPEN */

