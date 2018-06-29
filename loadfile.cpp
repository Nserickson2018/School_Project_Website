//
//  loadfile.cpp
//  Project4
//
//  Created by Jason Fries on 10/22/14.
//  Copyright (c) 2014 University of Iowa. All rights reserved.
//

#include <iostream>
#include <sstream>
#include <fstream>
#include <string>
#include "loadfile.h"
#include "book.h"
#include "list.h"
#include <cstdlib>

// Splits input string using the provided delimitter and
// assigns the resulting number of columns to n
std::string * split_str(std::string str, int & n, char delimitter)
{
    std::string token;
    std::stringstream ss;
    
    ss << str;
    n = 0;
    
    // PASS 1: Count the number of tokens that result from splitting the line
    while(getline(ss,token,delimitter))
    {
        n++;
    }
    
    ss.clear();                                   // reset our stringstream
    ss << str;
    
    std::string * values = new std::string[n];    // allocate our data
    
    // PASS 2: Store each field's value in a string array
    while(getline(ss,token,delimitter))
    {
        *values = token;
        values++;
    }
    values-=n;
    
    return values;
}

// Loads book data set and creates a linked list of Book
// objects. Input file is tab delimited with the column order:
//
// ISBN TITLE AUTHOR YEAR AVG_RATING
//
unsigned int load_book_data(char * filename, List & list)
{
    using namespace std;
    
    string line;
    ifstream fin;
    int i = 0;
    
    fin.open(filename);
    if(!fin)
    {
        cout << "File not found" << endl;
        return false;
    }
    
    //LinkedList * list = new LinkedList();
    
    while(getline(fin,line))    // read in a file line-by-line
    {
        i++;
        if(i == 1) continue;    // skip 1st row, which is column header names
        
        int n = 0;              // we should get five columns
        string * row = split_str(line,n);
        
        if(n != 5)
        {
            cout << "error reading row " << i << endl;
            return false;
        }
        
        // create Book object using this row's data
        string isbn = row[0];
        string title = row[1];
        string author = row[2];
        int year = atoi(row[3].c_str());
        float rating = atof(row[4].c_str());
        
        Book book = Book(isbn,title,author,year,rating);
        
        // Book object is created using automatic storage -- so we are adding
        // to our linked list by value (i.e., a copy). We could use a pointer
        // which would mean we only have to create the book once, but then we'd
        // have to make sure that book object was deleted at the end of our program.
        list.append(book);
        
        delete [] row;  // delete temporary row data
        
    }
    
    return true;
    
}
