# Changelog

## 1.0.2 (2026-11-16)

- Moodle 5.3 colour modes (experimental, off by default): the theme now keeps
  its own colours when a site turns them on. Before, the dark colour mode left
  activity names, section titles and course cards unreadable.
- Login pages: the page background is dark too, and the login card has inner
  padding in the two-column layout (Boost Union's side-by-side arrangement).
- Course page: the section collapse buttons are no longer white.
- Keyboard focus on links: the link text can be read (dark text on teal;
  it was light text on a white box).

## 1.0.1 (2026-10-30)

- Wording and documentation: the theme is described as a "Theme for Moodle™"
  (eLearning Fácil is an independent company); README with the same sections in
  English and Spanish (requirements, installation, customising); Boost Union's
  *Brand colour* setting named as the interface shows it; the INSTRUCTIONS block
  of `scss/preset.scss` points to this README for installation (the stand-alone
  preset instructions do not apply to the installed theme). No change in the
  design or in the compiled CSS.
- Boost Union dependency floor raised to v5.2-r13 (the release the theme is
  tested with).

## 1.0.0 (2026-10-22)

- First stable release: the Neon Night preset packaged as a Boost Union child
  theme. Tested on Moodle 5.2 and 5.3 with Boost Union
  v5.2-r13 (SCSS compilation, PHPUnit, Behat and axe-core WCAG 2.2 AA).
