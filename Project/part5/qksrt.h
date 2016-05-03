typedef unsigned long mylong;
void swap (mylong a[], int left, int right)
{
 mylong temp;
 temp=a[left];
 a[left]=a[right];
 a[right]=temp; 
}//end swap
 
void quicksort( mylong a[], int low, int high )
{
 int pivot;
 // Termination condition! 
 if ( high > low )
 {
  pivot = partition( a, low, high );
  quicksort( a, low, pivot-1 );
  quicksort( a, pivot+1, high );
 }
} //end quicksort
 
int partition( mylong a[], int low, int high )
{
 int left, right;
 mylong pivot_item;
 int pivot = left = low; 
 pivot_item = a[low]; 
 right = high;
 while ( left < right ) 
 {
  // Move left while item < pivot 
  while( a[left] <= pivot_item ) 
   left++;
  // Move right while item > pivot 
  while( a[right] > pivot_item ) 
   right--;
  if ( left < right ) 
   swap(a,left,right);
 }
 // right is final position for the pivot 
 a[low] = a[right];
 a[right] = pivot_item;
 return right;
}//end partition
 
void printarray(mylong a[], int n)
{
 int i;
 for (i=0; i<n; i++)
  printf(" %lu ", (unsigned long)a[i]);
 printf("\n");
}//end printarray
