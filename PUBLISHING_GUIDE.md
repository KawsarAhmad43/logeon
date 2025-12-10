# Publishing Logeon to GitHub and Packagist

This guide will walk you through publishing the Logeon package to GitHub and Packagist.

## Prerequisites

- GitHub account: **KawsarAhmad43**
- Packagist account: **KawsarAhmad43**
- Git installed on your machine
- Composer installed globally

## Step 1: Prepare the Package

The package is already prepared at: `~/logeon-package/`

### Verify Package Structure

```bash
cd ~/logeon-package
tree -L 3
```

You should see:
```
logeon-package/
├── ARCHITECTURE.md
├── CHANGELOG.md
├── composer.json
├── config/
│   └── logeon.php
├── INSTALLATION.md
├── LICENSE.md
├── PUBLISHING_GUIDE.md
├── README.md
├── resources/
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   └── views/
│       └── index.blade.php
├── routes/
│   └── web.php
└── src/
    ├── Http/
    │   └── Controllers/
    │       └── LogeonController.php
    └── LogeonServiceProvider.php
```

## Step 2: Initialize Git Repository

```bash
cd ~/logeon-package

# Initialize git (if not already done)
git init

# Set default branch to main
git branch -M main

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit: Logeon v1.0.0 - Laravel Log Viewer Package"
```

## Step 3: Create GitHub Repository

### Option A: Using GitHub CLI (gh)

```bash
# Install GitHub CLI if not installed
# sudo apt install gh  # Ubuntu/Debian
# brew install gh      # macOS

# Login to GitHub
gh auth login

# Create repository
gh repo create logeon --public --source=. --remote=origin --push

# Description
gh repo edit --description "A beautiful Laravel log viewer with filtering, charts, and real-time monitoring"

# Add topics
gh repo edit --add-topic laravel,log-viewer,monitoring,debugging,php,laravel-package
```

### Option B: Using GitHub Web Interface

1. Go to: https://github.com/new
2. Repository name: `logeon`
3. Description: `A beautiful Laravel log viewer with filtering, charts, and real-time monitoring`
4. Visibility: **Public**
5. **DO NOT** initialize with README (we already have one)
6. Click "Create repository"

Then push your code:

```bash
cd ~/logeon-package

# Add remote
git remote add origin https://github.com/KawsarAhmad43/logeon.git

# Push to GitHub
git push -u origin main
```

## Step 4: Create a Release Tag

```bash
cd ~/logeon-package

# Create and push tag for v1.0.0
git tag -a v1.0.0 -m "Release v1.0.0 - Initial release"
git push origin v1.0.0
```

### Create GitHub Release

#### Using GitHub CLI:

```bash
gh release create v1.0.0 \
  --title "v1.0.0 - Initial Release" \
  --notes "## Features

- Beautiful log viewer dashboard with Bootstrap 5
- Support for 4 log types: INFO, ERROR, WARNING, CUSTOM
- Advanced filtering by date range and log type
- Visual pie chart showing log distribution
- Clickable badges for quick type filtering
- Modal popup for detailed log view
- Full stack trace display for exceptions
- JSON context formatting for structured logs
- Pagination for large log files
- Configurable route prefix and middleware
- Publishable views, assets, and configuration
- Test route for generating sample logs
- Automatic production safety (test route disabled)
- Real-time log parsing from laravel.log
- Responsive design for mobile and desktop

## Installation

\`\`\`bash
composer require mediusware/logeon
php artisan vendor:publish --tag=logeon-assets
\`\`\`

## Documentation

See [README.md](https://github.com/KawsarAhmad43/logeon#readme) for full documentation."
```

#### Or using GitHub Web Interface:

1. Go to: https://github.com/KawsarAhmad43/logeon/releases/new
2. Tag version: `v1.0.0`
3. Release title: `v1.0.0 - Initial Release`
4. Description: Copy from CHANGELOG.md
5. Click "Publish release"

## Step 5: Submit to Packagist

### 5.1 Login to Packagist

1. Go to: https://packagist.org/login
2. Login with your account: **KawsarAhmad43**

### 5.2 Submit Package

1. Go to: https://packagist.org/packages/submit
2. Repository URL: `https://github.com/KawsarAhmad43/logeon`
3. Click "Check"
4. Review the package information
5. Click "Submit"

### 5.3 Set Up Auto-Update (Recommended)

To automatically update Packagist when you push to GitHub:

1. Go to your package page: https://packagist.org/packages/mediusware/logeon
2. Click "Settings" or "Edit"
3. Find "GitHub Service Hook" or "Auto-Update"
4. Follow instructions to add webhook to GitHub

**Or manually add webhook:**

1. Go to: https://github.com/KawsarAhmad43/logeon/settings/hooks
2. Click "Add webhook"
3. Payload URL: `https://packagist.org/api/github?username=KawsarAhmad43`
4. Content type: `application/json`
5. Secret: (leave empty or use Packagist API token)
6. Events: "Just the push event"
7. Click "Add webhook"

## Step 6: Verify Installation

Test the package installation in a fresh Laravel project:

```bash
# Create test Laravel project
composer create-project laravel/laravel test-logeon
cd test-logeon

# Install your package
composer require mediusware/logeon

# Publish assets
php artisan vendor:publish --tag=logeon-assets

# Check routes
php artisan route:list | grep logger

# Start server
php artisan serve

# Visit: http://localhost:8000/logger
```

## Step 7: Add Badges to README

Add these badges to your README.md:

```markdown
[![Latest Version on Packagist](https://img.shields.io/packagist/v/mediusware/logeon.svg?style=flat-square)](https://packagist.org/packages/mediusware/logeon)
[![Total Downloads](https://img.shields.io/packagist/dt/mediusware/logeon.svg?style=flat-square)](https://packagist.org/packages/mediusware/logeon)
[![License](https://img.shields.io/packagist/l/mediusware/logeon.svg?style=flat-square)](https://packagist.org/packages/mediusware/logeon)
```

Update README:

```bash
cd ~/logeon-package

# Add badges at the top of README.md (after title)
# Then commit and push
git add README.md
git commit -m "Add Packagist badges to README"
git push origin main
```

## Step 8: Future Updates

When you make changes and want to release a new version:

```bash
cd ~/logeon-package

# Make your changes
# ...

# Update CHANGELOG.md with new version

# Commit changes
git add .
git commit -m "Description of changes"
git push origin main

# Create new tag (e.g., v1.1.0)
git tag -a v1.1.0 -m "Release v1.1.0 - Description"
git push origin v1.1.0

# Create GitHub release
gh release create v1.1.0 --title "v1.1.0" --notes "Release notes here"

# Packagist will auto-update if webhook is configured
# Otherwise, manually update at: https://packagist.org/packages/mediusware/logeon
```

## Versioning Guidelines

Follow Semantic Versioning (SemVer):

- **MAJOR** version (1.0.0 → 2.0.0): Breaking changes
- **MINOR** version (1.0.0 → 1.1.0): New features, backward compatible
- **PATCH** version (1.0.0 → 1.0.1): Bug fixes, backward compatible

## Troubleshooting

### Package Not Found on Packagist

- Wait a few minutes after submission
- Check package status at: https://packagist.org/packages/mediusware/logeon
- Verify composer.json is valid: `composer validate`

### Auto-Update Not Working

- Check webhook status: https://github.com/KawsarAhmad43/logeon/settings/hooks
- Manually trigger update: https://packagist.org/packages/mediusware/logeon (click "Update")

### Installation Fails

- Verify minimum PHP version: `php -v` (should be 8.2+)
- Verify Laravel version: `php artisan --version` (should be 11.x or 12.x)
- Check composer.json requirements

## Support

- **GitHub Issues**: https://github.com/KawsarAhmad43/logeon/issues
- **Email**: kawsarahmad43@gmail.com
- **Packagist**: https://packagist.org/packages/mediusware/logeon

## Checklist

Before publishing, ensure:

- [ ] All files are committed
- [ ] composer.json is valid (`composer validate`)
- [ ] README.md is complete
- [ ] CHANGELOG.md is updated
- [ ] LICENSE.md is present
- [ ] Version tag is created
- [ ] GitHub repository is public
- [ ] Package is submitted to Packagist
- [ ] Auto-update webhook is configured
- [ ] Package installs successfully in test project
- [ ] Routes work correctly
- [ ] Assets are published correctly

## Quick Reference

```bash
# Package location
cd ~/logeon-package

# GitHub repository
https://github.com/KawsarAhmad43/logeon

# Packagist page
https://packagist.org/packages/mediusware/logeon

# Installation command
composer require mediusware/logeon

# Publish assets
php artisan vendor:publish --tag=logeon-assets
```

---

**Ready to publish? Follow the steps above in order!**
