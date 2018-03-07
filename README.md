# FooBAR: Proposed solution to counting foot traffic in a populated student facility

FooBAR is the first, mid-semester project for Dr. Shawn Lupoli in his CSCE 315-504 class. This repository contains the python source code that will interact with Arduino sensors and a MySQL database hosted by the university in order to create a functional product that satisfies all customer requirements.

## Installment
Obtaining the source code for this project is straightforward. If the user is new to git, than a download link (giant green button) can be found in the top right of the GitHub file explorer. However, if the user is familiar with git, then all they must do is a simple `git clone <URL>,` using the URL link that can also be found under the big green button above.

#### Note for team members
It is recommended to clone this repository in a location <b>outside</b> of the team Drive folder. This way, changes are not being synced inadvertently, and commits overwritten. This theoretically would not be a problem if proper branching convention is being followed, but there is nothing wrong with being extra safe.

### Setting up the Raspberry Pi
The hardware design for this project can be found in the picture. Certain files but be configured on the raspberry pi for it to be able to communicate on the Texas A&M WiFi network. In the setup folder,
there is a file labeled `wpa_supplicant.conf`. The contents of this file must be added to the users Pi at `/etc/wpa_supplicant/wpa_supplicant.conf`. There is another file in the setup folder as well,
`interfaces`. The contents of this file must be added to the users `/etc/network/interfaces` file on the Pi. In this case, the users has the option of either commenting out their current `wlan0`
configuration, or naming this new configuration `wlan1`. However, user be warned that this was only testing as `wlan0`.

## Maintenance
   To maintain and develop this project, follow the steps below.
   1. Clone it as described in the Installment section
      * `git clone`
      * `git status`
         * Check that everything worked, that you are up to date, and that you are on the `master` branch

   2. Create a new branch for your individual development.<br/>
      * The proper convention for branching is to make a new branch for any new feature, bug fix, or any other individual component added to the code base.<br/>
      * `git checkout -b <your branch name>.`
         * Create a new branch that is exactly the same as the current branch you are on when you ran the command
         * Any changes made will not affect the original branch. 
         * <b> This is very important when branching off of the master branch. We do not want to make changes directly to master. </b> 
      * `git status` 
         * Be sure that you are not on your new branch. 
      * Now, you will be able to write as much code as you want, test it, save it, or delete it, and not affect the rest of the people on the project. <br/>
   3. When you are ready to add something to your branch (code that definitely works and that you want to keep), you'll need to commit it.
      * `git status`
         * See a list of files that have been modified, but `not staged for commit.` 
      * `git add .` 
         * Add all of the files in your <i>current directory</i> (`.`) 
         * If you do <b>not</b> want all of these files, then add them individually: 
               `git add <path/to/file>`<br/>
      * `git commit -m <your message>`
         * This will save all of your changes to the current branch that your on. Descriptive messages are good!
   4. When you are ready, push commits to the remote repository.
      * `git push` 
         * Enter login credentials if prompted.
         * Follow the recommended instructions if prompted for an upstream branch.<br/>
   5. Before adding changes to the final product, check for conflicts.
      * `git status`
         * Make sure all of your changes have been committed.
         * If you have changes that you do not want to keep, simply run `git stash` to stash them away. Note: this is not technically the purpose of `stash.` However, it is good enough for our purposes. 
         * If you want to apply these changes to the new branch for some reason, run `git stash pop`. 
    6. Update the local target branch (i.e. `master`).
       * `git checkout master`
          * Move to the target branch
       * `git pull`
          * Pull in any remote updates to the branch that weren't already there.
          * As long as you are not making any changes directly to master (which you should not be), then this should not result in any conflicts. 
       * `git checkout <your branch>`
          * Check out your custom branch
       * `git merge master.`
          * merge the target branch into your custom branch 
          * This will merge `master` <i>into</i> `your branch`.<br/>
    7. Resolve `Merge Conflicts` errors.
       * Locate the automatic markup in your code. 
       * The section between `<<<< HEAD` and `=======` is the code you wrote. Anything between `=======` and `>>>>> master` is the code in the master branch.
       * Compare the two segments, and rework things until you have the right code. 
       * Commit these changes, and finally push your branch to the remote repository.
   8. Open a <i>pull request</i>. 
      * Return to the GitHub web portal and click the `New pull request` button. 
      * Select the `base` branch as master (or whatever branch you branched off), and `compare` as your branch.
         * If you have recently pushed a branch, then it will probably recommend that branch to create a pull request with.
      * Any conflicts should have been resolved in the previous step, but if there are more be careful to resolve them all and try again. 
      * On the right side of the page, add a user (the repo owner is a good choice) as a `Reviewer`, then submit the request. 
      * When the reviewer has checked it and verified that it is a good change, then it will be merged into the branch as a new commit. 
      
Congratulations! You have now successfuly contributed to the final product.
