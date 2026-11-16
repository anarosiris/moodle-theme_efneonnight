@theme @theme_efneonnight
Feature: Using the Neon Night theme
  In order to give my site the Neon Night look
  As an admin
  I need to select the theme and see the pages rendered with it

  @javascript
  Scenario: Select the theme and browse the site with it
    Given the following config values are set as admin:
      | theme | efneonnight |
    When I log in as "admin"
    Then "link[rel='stylesheet'][href*='efneonnight']" "css_element" should exist
    And I am on site homepage
    And "link[rel='stylesheet'][href*='efneonnight']" "css_element" should exist
    And "#page-footer" "css_element" should exist

  Scenario: The theme appears in the theme selector
    When I log in as "admin"
    And I navigate to "Appearance > Themes" in site administration
    Then I should see "Neon Night"
