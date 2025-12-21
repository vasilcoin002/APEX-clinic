export const Validators = {
    isRequired: (value) => {
        return value && value.trim() !== "";
    },

    isValidPhone: (value) => {
        return /\d/.test(value);
    },

    isValidEmail: (value) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    },

    getPasswordErrors: (password) => {
        const errors = [];
        if (!/.{8,}/.test(password)) errors.push("length");
        if (!/[A-Z]/.test(password)) errors.push("uppercase");
        if (!/[a-z]/.test(password)) errors.push("lowercase");
        if (!/\d/.test(password)) errors.push("digit");
        
        return {
            isValid: errors.length === 0,
            missing: errors
        };
    },

    doPasswordsMatch: (pass1, pass2) => {
        return pass1 === pass2;
    }
};