svn status | grep ^? | cut -c9- | xargs rm -rf
svn revert . -R
svn update
