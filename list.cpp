//
//list.cpp
//Project 4
//
//Created by Nicholas Erickson

#include <iostream>
#include "list.h"


List::List()
{
  //set the initial sizes of the list and the array
  m_listSize=0;
  m_arraySize=271381;
  
  //create a new book array abject
  bookArray = new Book[m_arraySize];
}

List::~List()
{
  delete[] bookArray;
}

void List::append(Book item)
{
  //if list size is less than array size, add the element to array, otherwise make the array size bigger and append
  //the element to the array
  if(m_listSize==m_arraySize){
    //increase the set array size by one to accomodate a new entry
    m_arraySize*=2;
    
    Book* newArrPtr=new Book[m_arraySize];
    
    for(int n=0; n<=m_listSize; n++){
     newArrPtr[n]=bookArray[n]; 
    }
    
    delete[] bookArray;
    
    bookArray=newArrPtr;
    //make the empty spot after the last occupied spot the new book element

  }
  bookArray[m_listSize+1]=item;
    
  m_listSize+=1;
}

bool List::remove(Book item)
{
    std::cout<<"Item to be removed: "<<item<<std::endl;
    std::cout<<"Original array size: "<<m_listSize<<std::endl;
  //loop through to find the 'item' in the array
  for(int n=0; n<=m_listSize; n++){
    //if the current item is equal to the item being looked for...
    if(bookArray[n]==item){
        //if n is equal to the size of the current list..
        if(n==m_listSize){
            //just remove the last element and...
            //...decrease the size of the list
            m_listSize=m_listSize-1;
            return true;
        } else {
            //go through array and set the current value to the value in front of it
            for(int i=n; i<=m_listSize; i++){
                //if we are at the last element...
                if(i==m_listSize) {
                    //just 'remove' the last element and...
                    //...decrease the size of the list
                    m_listSize = m_listSize - 1;
                } else {
                    bookArray[i]=bookArray[i+1];
                }
            //return true;
        }
      }
    }
  }
  std::cout<<"New list size: "<<m_listSize<<std::endl;
    return false;
}

bool List::contains(Book item) const
{
  for(int i=0; i<=m_listSize; ++i){
    if(bookArray[i]==item){
      return true;
    } else {
      continue;
    }
  }
  return false;

}

int List::size() const
{
  //return sizeof(bookArray);
  return m_listSize;
}

Book& List::operator[](int idx) const
{
  return bookArray[idx];
}


