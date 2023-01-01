#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <fcntl.h>
#include <unistd.h>

int main() {
const int MAX=1000;
int f1, f2, n;
char buf [MAX];
char text[100];
// A) Créer et ouvrir un nouveau fichier “name.txt” et écrire dedans votre nom et prénom
f1=open("ch.txt", O_WRONLY|O_CREAT|O_TRUNC, S_IRWXU);
if( f1 ==-1 ){
perror("creation fichier ch.txt impossible"); exit(1);
}
else {
char* mon_msg="1 2 3 4 5 6 7 8 9 10\n";
write(f1,mon_msg,strlen(mon_msg));
close(f1);
}
}

