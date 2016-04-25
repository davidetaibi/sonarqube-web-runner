#!/bin/bash

#read parameters from command line
#for i in $*
#do
# eval $i
#done

if [ "$1" == "" ] || [ "$2” == "" ] || [ "$3” == "" ]; then
    echo syntax error - try execute-sonar-svn.sh project-name initialRevision finalRevision
    echo a file called “project-name.properties” containing the sonarqube configuration and the property svnRepo must exist in the current directory 
exit 1
else

project=$1

svn=$(cat $project.properties | grep "svnRepo" |cut -d'=' -f2)
echo svn: $svn
#echo max revision: $maxRev
mkdir $project
echo Analysing project $project from revision $2 to $3 
echo "Please Press a key to continue "
#read input_variable
#echo "You entered: $input_variable"
#get the revision n. in svn and revision date

#checkout the first revision and run the analysis

echo svn co --revision $2 $svn
svn co --revision $2 $svn
date=“”

#for each revision

for rev in `seq $2 $3`;
  do 
    cd $project    
    echo svn up --revision $rev -q
    svn up --revision $rev -q
    
    date=$(svn info |grep "Last Changed Date:" |awk '{print $4}')
    cd .. 
    ../sonar-runner/bin/sonar-runner -Dproject.settings=$project.properties -Dsonar.projectDate=$date 
    date=“”
done  
rm -rf $project
  

fi
