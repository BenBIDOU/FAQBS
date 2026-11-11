<?php

/**
 * FAQBS - Fonctions helpers globales
 * Ces fonctions sont disponibles dans toute l'application
 */

if (!function_exists('faqbs_config')) {
    /**
     * Récupère une valeur de configuration FAQBS
     * 
     * @param string $key Chemin de la configuration (ex: 'colors.primary')
     * @param mixed $default Valeur par défaut si non trouvée
     * @return mixed
     */
    function faqbs_config(string $key, $default = null)
    {
        $config = config('faqbs', []);
        
        if (str_contains($key, '.')) {
            $keys = explode('.', $key);
            $value = $config;
            
            foreach ($keys as $k) {
                if (!isset($value[$k])) {
                    return $default;
                }
                $value = $value[$k];
            }
            
            return $value;
        }
        
        return $config[$key] ?? $default;
    }
}

if (!function_exists('faqbs_color')) {
    /**
     * Récupère une couleur de la configuration
     * 
     * @param string $name Nom de la couleur (primary, secondary, success, etc.)
     * @return string
     */
    function faqbs_color(string $name): string
    {
        return faqbs_config("colors.{$name}", '#000000');
    }
}

if (!function_exists('faqbs_gradient')) {
    /**
     * Récupère un dégradé de la configuration
     * 
     * @param string $name Nom du dégradé (agora, red, blue)
     * @return string
     */
    function faqbs_gradient(string $name): string
    {
        return faqbs_config("gradients.{$name}", '');
    }
}

if (!function_exists('faqbs_group_icon')) {
    /**
     * Récupère l'icône d'un groupe de discussion
     * 
     * @param string $groupName Nom du groupe
     * @return string
     */
    function faqbs_group_icon(string $groupName): string
    {
        $groups = faqbs_config('discussion_groups', []);
        return $groups[$groupName]['icon'] ?? 'bi-people';
    }
}

if (!function_exists('faqbs_group_color')) {
    /**
     * Récupère la couleur d'un groupe de discussion
     * 
     * @param string $groupName Nom du groupe
     * @return string
     */
    function faqbs_group_color(string $groupName): string
    {
        $groups = faqbs_config('discussion_groups', []);
        return $groups[$groupName]['color'] ?? faqbs_color('primary');
    }
}

if (!function_exists('faqbs_normalize_group')) {
    /**
     * Normalise un nom de groupe (alias -> nom standard)
     * 
     * @param string $groupName Nom du groupe à normaliser
     * @return string
     */
    function faqbs_normalize_group(string $groupName): string
    {
        $groupName = trim($groupName);
        $lowerName = strtolower($groupName);
        
        $groups = faqbs_config('discussion_groups', []);
        
        foreach ($groups as $standardName => $config) {
            foreach ($config['aliases'] as $alias) {
                if (str_contains($lowerName, $alias)) {
                    return $standardName;
                }
            }
        }
        
        return $groupName ?: 'Président';
    }
}

if (!function_exists('faqbs_group_options')) {
    /**
     * Génère les options HTML pour un select de groupes
     * 
     * @param string $selected Groupe sélectionné
     * @return string HTML options
     */
    function faqbs_group_options(string $selected = ''): string
    {
        $order = faqbs_config('group_order', []);
        $html = '<option value="">Tous les groupes</option>';
        
        foreach ($order as $group) {
            $html .= sprintf(
                '<option value="%s" %s>%s</option>',
                e($group),
                $group === $selected ? 'selected' : '',
                e($group)
            );
        }
        
        return $html;
    }
}

if (!function_exists('faqbs_date_filter_options')) {
    /**
     * Génère les options HTML pour un select de filtre de date
     * 
     * @param string $selected Option sélectionnée
     * @return string HTML options
     */
    function faqbs_date_filter_options(string $selected = ''): string
    {
        $filters = faqbs_config('date_filters', []);
        $html = '';
        
        foreach ($filters as $value => $label) {
            $html .= sprintf(
                '<option value="%s" %s>%s</option>',
                e($value),
                $value === $selected ? 'selected' : '',
                e($label)
            );
        }
        
        return $html;
    }
}

if (!function_exists('faqbs_sort_options')) {
    /**
     * Génère les options HTML pour un select de tri
     * 
     * @param string $selected Option sélectionnée
     * @return string HTML options
     */
    function faqbs_sort_options(string $selected = ''): string
    {
        $options = faqbs_config('sort_options', []);
        $html = '';
        
        foreach ($options as $value => $label) {
            $html .= sprintf(
                '<option value="%s" %s>%s</option>',
                e($value),
                $value === $selected ? 'selected' : '',
                e($label)
            );
        }
        
        return $html;
    }
}

if (!function_exists('faqbs_group_discussions')) {
    /**
     * Regroupe les discussions par groupe avec normalisation des noms
     * 
     * @param array|Collection $discussions Liste des discussions
     * @return array Discussions groupées par nom de groupe normalisé
     */
    function faqbs_group_discussions($discussions): array
    {
        $groupOrder = faqbs_config('group_order', []);
        $allGroups = [];
        
        // Convertir en array si c'est une Collection
        $discussionsArray = $discussions instanceof \Illuminate\Support\Collection 
            ? $discussions->all() 
            : ($discussions ?? []);
        
        foreach ($discussionsArray as $discussion) {
            $groupName = $discussion->group ?? '';
            $normalizedName = faqbs_normalize_group($groupName);
            
            if (!isset($allGroups[$normalizedName])) {
                $allGroups[$normalizedName] = [];
            }
            $allGroups[$normalizedName][] = $discussion;
        }
        
        // Filtrer selon l'ordre désiré
        $filteredGroups = [];
        foreach ($groupOrder as $group) {
            $filteredGroups[$group] = $allGroups[$group] ?? [];
        }
        
        return $filteredGroups;
    }
}

if (!function_exists('faqbs_get_group_icon')) {
    /**
     * Récupère l'icône Bootstrap Icons pour un groupe
     * 
     * @param string $groupName Nom du groupe
     * @return string Classe d'icône
     */
    function faqbs_get_group_icon(string $groupName): string
    {
        return faqbs_group_icon($groupName);
    }
}

if (!function_exists('faqbs_group_badge')) {
    /**
     * Génère un badge pour un groupe
     * 
     * @param string $groupName Nom du groupe
     * @param string $count Compteur optionnel
     * @return string HTML badge
     */
    function faqbs_group_badge(string $groupName, ?int $count = null): string
    {
        $icon = faqbs_group_icon($groupName);
        $badge = '<span class="badge bg-secondary badge-custom">' . e($groupName) . '</span>';
        
        if ($count !== null && $count > 0) {
            $badge = '<span class="badge bg-success">' . e($count) . '</span>';
        }
        
        return $badge;
    }
}
