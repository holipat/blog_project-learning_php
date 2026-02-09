# TODO List - Text Visibility Fix on Card Hover

## Problem
- Title text visibility issues when hovering over cards on the homepage
- Floating petals and glow orbs may overlap content
- Hover effects create dark backgrounds that reduce text contrast

## Solutions to Implement

### 1. Fix z-index stacking context
- [x] Ensure text content has proper z-index above decorative elements
- [x] Fix glow orbs z-index (currently 0, should be behind content)

### 2. Enhance card hover visibility
- [x] Add better text color contrast on hover
- [x] Add text shadow improvement on hover states
- [x] Prevent background color from making text unreadable

### 3. Title hover effects
- [x] Add proper hover transitions for titles
- [x] Ensure titles remain visible and readable on hover

## File to Edit
- `public/css/themes/dark-fantasy-romance.css`

## Implementation Steps
- [x] Read the current CSS file
- [x] Fix z-index issues for decorative elements (petal z-index: -1)
- [x] Enhance hover states for better text visibility
- [x] Add specific rules for title text on hover

## Changes Made
1. **Floating Petals**: Changed z-index from 1 to -1 to ensure they stay behind all content
2. **Hover Text Visibility**: Added specific CSS rules for:
   - Titles (h5, post-list-title) turn to lighter rose color with glow effect on hover
   - Muted text becomes more visible (dusty-rose) on hover
   - Enhanced background opacity for better contrast

The fixes are complete. Refresh your browser to see the improved text visibility on hover.

