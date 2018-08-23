//
//  list.h
//  Project4
//
//  Created by Jason Alan Fries on 10/17/13.
//  Copyright (c) 2013 Jason Fries. All rights reserved.
//

#ifndef LIST_H
#define LIST_H

#include <iostream>

#include "book.h"

class List {
    
private:
    //TODO: decide on using linked-list based or array based list... 
    //      Add appropriate member variables here
    int m_listSize;
    int m_arraySize;
    Book* bookArray;
    
public:
    List();
    ~List();
    
    void append(Book item);
    bool remove(Book item);
    bool contains(Book item) const;
    int size() const;

    Book & operator[](int idx) const;
};


#endif
