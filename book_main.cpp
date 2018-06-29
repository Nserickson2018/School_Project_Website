//
//  main.cpp
//  HW04
//  Author: Nicholas Erickson 

#include <iostream>
#include "list.h"
#include "loadfile.h"
#include "book.h"
#include <new>


int main( int argc, const char * argv[] ) {
    /*Book mybook1{"199283918", "Harry Potter and the Deathly Hallows", "JK Rowling", 2004, 9.0};
    Book mybook2("928837483", "The Hunger Games", "Suzanne Collins", 2009, 8.5);
    Book mybook3("872637748", "Deadpool Kills the Marvel Universe", "akjndsnf", 2010, 4.8);
    Book mybook4("873664828", "Life: The Science of Biology", "jsisfubf", 2015, 3.2);
    List titleList;
    
    //std::cout<<"Book: "<<*mybook1<<std::endl;
    //std::cout<<*titleList<<std::endl;
    titleList.append(mybook1);
    titleList.append(mybook2);
    titleList.append(mybook3);
    titleList.append(mybook4);
    
    //std::cout<<"Boolean: "<<titleList->contains(*mybook2)<<std::endl;
    
    //std::cout<<"size: "<<titleList->size()<<std::endl;
    
    //std::cout<<titleList->operator[](1)<<std::endl;
    for(int a=0; a<titleList.size()+1; a++){
      std::cout<<titleList[a]<<std::endl;
    }
    
    std::cout<<titleList.remove(mybook2)<<std::endl;

    for(int a=0; a<titleList.size()+1; a++){
        std::cout<<titleList[a]<<std::endl;
    }*/
    
    List mylist;
    load_book_data((char*)argv[1], mylist);
    
    //for(int n=0; n<=mylist.size(); n++){
      //std::cout<<mylist[n]<<std::endl;
    //}
    
    //the following sorts the list by rating in descending order.
    int i, j, flag=1;
    Book temp;
    int listlength=mylist.size();
    for(i=1; (i<=listlength)&&flag; i++){
      flag=0;
      for(j=0; j<(listlength-1); j++){
	if(mylist[j+1].rating()>mylist[j].rating()){
	  temp=mylist[j];
	  mylist[j]=mylist[j+1];
	  mylist[j+1]=temp;
	  flag=1;
	}
      }
    }
    
    //prints out the sorted list
    for(int n=0; n<=mylist.size(); n++){
      std::cout<<mylist[n]<<std::endl;
    }
    
    //prints out the size of the list
    std::cout<<"Size of list: "<<mylist.size()<<std::endl;
    
    
    return 0;
}

