@api
Feature: OGFPP
  As an administrator,
  I want fieldable panels panes from only my group to be visible when adding panes,
  So that I can focus on the content I care about.

  Scenario: Putting Fieldable Panels Panes in groups
    Given I am logged in as a user with the "administrator" role



    # Add English Group
    When I visit "/node/add/group"
      And I fill in the following:
        | Title               | English Department |
         When I press the "Save" button
         Then I should see "English Department"

    # Add Chemistry Group
    When I visit "/node/add/group"
      And I fill in the following:
      | Title               | Chemistry Department |
       When I press the "Save" button
       Then I should see "Chemistry Department"

   # Add English Landing Page
    When I visit "/node/add/page"
    # Then print last response
    And I fill in the following:
      | Title               | English Dept Landing Page |
      And select "English Department" from "og_group_ref[und][0][default][]"
      When I press the "Save" button
      Then I should see "English Department"
      Then I should see "English Dept Landing Page"

    # Add Chemistry Landing Page
    When I visit "/node/add/page"
    # Then print last response
    And I fill in the following:
      | Title               | Chemistry Dept Landing Page |
      And select "Chemistry Department" from "og_group_ref[und][0][default][]"
      When I press the "Save" button
        Then I should see "Chemistry Department"
        Then I should see "Chemistry Dept Landing Page"
    Then print current URL

    # Add English Sidebar blurb
    When I visit "admin/structure/fieldable-panels-panes/manage/fieldable-panels-pane/add"
    # Then print last response
    And I fill in the following:
      | Title                | English Department Sidebar Blurb |
      | Administrative title | English Department Sidebar Blurb |
      | Category             | FPP                              |

    And select "English Department" from "og_group_ref[und][0][default][]"
    Then I press the "Save" button

    # Add Chemistry Sidebar blurb
    When I visit "admin/structure/fieldable-panels-panes/manage/fieldable-panels-pane/add"
    # Then print last response
    And I fill in the following:
      | Title                | Chemistry Department Sidebar Blurb |
      | Administrative title | Chemistry Department Sidebar Blurb |
      | Category             | FPP                                |
    And select "Chemistry Department" from "og_group_ref[und][0][default][]"
 #   Then I break
    Then I press the "Save" button

    # Go To English Panelizer
    When I visit "/admin/content"
    And I click "English Dept Landing Page"
    Then print current URL
    And I click "Panelizer"
    Then print current URL
    And I click "content" in the "Full page override" row

    Then print current URL

   # Then I break
