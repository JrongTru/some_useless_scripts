/*+--------------------------------------------------------+
    > File Name: tst.cc
    > Author: TruJrong
    > Mail: JrongTru@outlook.com 
    > Created Time: 2017年10月16日 星期一 18时00分06秒
 +-------------------------------------------------------+*/

#include <iostream>
#include <regex>
#include <sstream>
#include <string>
#include <fstream>

using namespace std;

const string path("./ser.conf");

int main(int argc, char * argv[])
{
     stringstream ss;
     ifstream fin;
     fin.open(path, ios::in);
     string buf("");

     string r_str("[^#]\\s*?(\\S+)?\\s*?=\\s*?(\\S+)\\s*?[#]?.*");
     regex r(r_str);
     smatch sm;

     while(getline(fin, buf))
     {
          regex_match(buf, sm, r);
          cout << "\n+---------------------------------------------------+" << endl;
          cout << "string buffer: " << buf << endl;
          for(int i = 0; i < sm.size(); ++i)
          {
               cout << "matched[" << i << "]: " << sm[i] << endl;
          }          
          cout << "+---------------------------------------------------+" << endl;
     }
     
     return 0;
}

