/**
 * Application Constants
 * Centralized configuration values used across the application.
 * @author RecyShare Team
 */

/**
 * Default placeholder image for recipes without an image
 */
export const DEFAULT_RECIPE_IMAGE = '/assets/food/no-image.jpg';

/**
 * API endpoints
 */
export const API_ENDPOINTS = {
    TOGGLE_FAVORITE: (recipeId) => `/recipes/${recipeId}/toggle-favorite`,
    DELETE_RECIPE: (recipeId) => `/recipes/${recipeId}`,
    RECIPES_SEARCH: '/recipes',
};

/**
 * Time formatting constants
 */
export const TIME_FORMAT = {
    MINUTES_PER_HOUR: 60,
};
