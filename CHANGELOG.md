# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 0.1.0-alpha - unreleased

This is an alpha version! The changes listed here are not final.

### Added
- Add Alert icon to the error admin page
- Add checks to the Site Health page
- Add custom hook to handle viewport sizes via CSS
- Added Social card to My Jetpack.
- Added the list of installed pĺugins to the initial state
- add get themes to synced callables in Protect
- Add installedThemes to the initial state
- Add notifications to the menu item and the admin bar
- Add status polling to the Protect admin page.
- Creates Status Class
- Empty state screen
- Expose and use IconsCard component
- Flush cache on plugin deactivation
- Footer component
- Handle error in the UI
- Hooks on plugin activation and deactivation
- Hook to read data from the initial state
- Implement Footer
- initial release
- JS Components: Introduce Alert component. Add error to ProductOffer components
- more options to the testing api responses
- Protect: add error message when adding plugin fails
- Protect: Add first approach of Interstitial page
- Protect: Add Jetpack Scan to promotion section when site doesn't have Security bundle
- Protect: Add missing prop-types module dependency
- Protect: Add Navigation dropdown mode and use it for small/medium screens
- Protect: add ProductOffer component
- Protect: Add product offer component
- Protect: Add title and redirect for vul at wpscan
- Protect: Change ConnectScreen by the Interstitial component
- Protect: implement Add Security bundle workflow
- Protect: Introduce Accordion component
- Protect: Introduce Navigation component
- Protect: Introduce Summary component
- Protect: Introduce VulnerabilitiesList component
- Protect: record admin page-view and get security from footer events
- Protect: render Security component with data provided by wpcom
- Protect: request and expose to the client the Security bundle data
- Protect: update Logo

### Changed
- Cache empty statuses for a short period of time
- Changed connection screen to the one that does not require a product
- Changed the method used to disconnect
- Changed the wording for the initial screen.
- Change expiration time of plugin cache
- Configure Sync to only what we need to sync
- Janitorial: require a more recent version of WordPress now that WP 6.0 is coming out.
- JS Components: Add subTitle prop to ProductOffer component
- JS Components: iterate over Dialog component
- Protect: Add empty state for no vuls
- Protect: Add popover at Badge
- Protect: clean connection data. Update to latest connection API
- Protect: improve Dialog layout in medium viewport size
- Protect: Move VulnerabilitiesList to section hero
- Protect: New VulsList
- Protect: Redesign Summary component
- Protect: Re implement "Your results will be ready soon" layout
- Protect: re implement Admin page by using Dialog component
- Protect: Truncate items at NavigationGroup
- Protect: tweak footer
- Protect: Update Footer and VulsList for small/medium viewport
- Protect: Update Navigation to be external controlled
- Protect: update Protect icon
- Protect: Update VulnerabilitiesList to remove severity and add fixed in
- Protect: use data provided by My Jetpack to render Product offer
- Protect: use weight Button prop to style the "learn more" footer link
- Remove use of `pnpx` in preparation for pnpm 7.0.
- Replace deprecated external-link variation by using isExternalLink prop
- require only site level connection
- Updated package dependencies
- Updated package dependencies.
- Update package.json metadata.
- Updates CTA wording to reduce confusion when user already has Jetpack Security Bundle which includes Jetpack Scan
- Update the Status when connection is established
- Use a different copy when there are no found vulnerabilities but there are still some unchecked items

### Removed
- Removed Full Sync from loaded modules as Full Sync Immediately is present by default now

### Fixed
- Adjust spacing and overflow properties of the navigation labels to improve display of long names.
- Fix Connectino initialization
- Protect: Fix Fatal when checking whether site site has vuls
- Protect: fix right margin in primary layout
