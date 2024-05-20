#!/bin/bash

# Ensure the script is executed in a Git repository
if [ ! -d ".git" ]; then
    echo "Error: This script must be run inside a Git repository."
    exit 1
fi

# Retrieve the list of unique authors and count their commits
git log --format='%aN' | sort | uniq -c | sort -rn