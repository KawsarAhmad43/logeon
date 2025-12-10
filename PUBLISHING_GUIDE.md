# Publishing Logeon to GitHub & Packagist

This guide explains how to publish the Logeon package to GitHub and Packagist.

## Prerequisites

- GitHub account: https://github.com/KawsarAhmad43
- Packagist account: https://packagist.org (KawsarAhmad43)
- Git installed locally
- Composer installed

## Step 1: Initialize Git Repository

```bash
cd ~/logeon-package
git init
git add .
git commit -m "Initial commit: Logeon package v1.0.0"
```

## Step 2: Create GitHub Repository

1. Go to https://github.com/new
2. Create repository named: `logeon`
3. Description: "A beautiful Laravel log viewer with filtering, charts, and real-time monitoring"
4. Make it **Public**
5. Do NOT initialize with README (we already have one)

## Step 3: Push to GitHub

```bash
cd ~/logeon-package
git remote add origin https://github.com/KawsarAhmad43/logeon.git
git branch -M main
git push -u origin main
```

## Step 4: Create GitHub Release

1. Go to https://github.com/KawsarAhmad43/logeon/releases
2. Click "Create a new release"
3. Tag version: `v1.0.0`
4. Release title: `Logeon v1.0.0 - Initial Release`
5. Description:
   ```
   ## Features
   - Beautiful log viewer dashboard
   - Advanced filtering (date range + type)
   - Visual pie chart
   - 4 log types support (INFO, ERROR, WARNING, CUSTOM)
   - Full stack trace display
   - Responsive design
   - Configurable middleware
   
   ## Installation
   ```bash
   composer require kawsarahmad43/logeon
   php artisan vendor:publish --tag=logeon-assets
   ```
   
   Visit: http://yourapp.com/logger
   ```
6. Click "Publish release"

## Step 5: Register on Packagist

1. Go to https://packagist.org/submit
2. Enter repository URL: `https://github.com/KawsarAhmad43/logeon`
3. Click "Check"
4. Click "Submit"

## Step 6: Set Up Auto-Update (GitHub Hook)

1. Go to https://packagist.org/profile/
2. Find "Logeon" package
3. Click "Edit"
4. Copy the "GitHub Service Hook" URL
5. Go to GitHub repository settings: https://github.com/KawsarAhmad43/logeon/settings/hooks
6. Click "Add webhook"
7. Paste the URL
8. Content type: `application/json`
9. Click "Add webhook"

Now Packagist will automatically update when you push to GitHub!

## Step 7: Verify Installation

Test the package installation:

```bash
# Create a test Laravel project
composer create-project laravel/laravel test-logeon
cd test-logeon

# Install the package
composer require kawsarahmad43/logeon

# Publish assets
php artisan vendor:publish --tag=logeon-assets

# Generate test logs
php artisan tinker
>>> \Log::info('Test log');
>>> exit

# Start server
php artisan serve

# Visit http://localhost:8000/logger
```

## Updating the Package

When you make updates:

1. Update version in `composer.json`
2. Update `CHANGELOG.md`
3. Commit changes:
   ```bash
   git add .
   git commit -m "Update: Description of changes"
   git push origin main
   ```
4. Create a new release on GitHub
5. Packagist will auto-update

## Version Numbering

Use Semantic Versioning (MAJOR.MINOR.PATCH):

- **MAJOR**: Breaking changes (1.0.0 → 2.0.0)
- **MINOR**: New features (1.0.0 → 1.1.0)
- **PATCH**: Bug fixes (1.0.0 → 1.0.1)

Examples:
- `v1.0.0` - Initial release
- `v1.1.0` - Added new feature
- `v1.0.1` - Bug fix
- `v2.0.0` - Major rewrite

## Troubleshooting

### Package not showing on Packagist

1. Check GitHub repository is public
2. Verify `composer.json` is valid:
   ```bash
   composer validate
   ```
3. Wait a few minutes for Packagist to index
4. Manually trigger update on Packagist profile

### Auto-update not working

1. Verify GitHub webhook is configured
2. Check webhook delivery logs in GitHub settings
3. Re-add the webhook if needed

### Installation fails

1. Verify package name is correct: `kawsarahmad43/logeon`
2. Check PHP version requirement (^8.2)
3. Check Laravel version requirement (^11.0|^12.0)
4. Run `composer update` instead of `composer install`

## Package Maintenance

### Regular Updates

- Monitor GitHub issues
- Fix bugs promptly
- Add features based on feedback
- Keep dependencies updated

### Documentation

- Keep README.md updated
- Update CHANGELOG.md for each release
- Add examples and screenshots
- Document configuration options

### Testing

- Write unit tests
- Test with multiple Laravel versions
- Test on different PHP versions
- Test installation in fresh Laravel projects

## Support

For questions about publishing:
- GitHub: https://github.com/KawsarAhmad43/logeon/issues
- Packagist: https://packagist.org/packages/kawsarahmad43/logeon
